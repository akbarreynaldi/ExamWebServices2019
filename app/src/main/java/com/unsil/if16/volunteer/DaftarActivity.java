package com.unsil.if16.volunteer;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Spinner;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class DaftarActivity extends Activity {

    EditText       nama;
    EditText       alamat;
    EditText       pendidikan;
    EditText       tempat_lahir;
    EditText       username;
    EditText       password;
    EditText       no_hp;
    EditText       email;
    EditText       _tgl;
    EditText       _thn;
    Button         bDaftar;
    volunteerKoneksi kon;
    Spinner        blnSpinner;
    RadioGroup pendidikanRadioGroup;
    RadioButton     SD;
    RadioButton     SMP;
    RadioButton     SMA;
    RadioButton     S1;
    RadioButton     S2;
    RadioButton     S3;

    String pendidikanDipilih;
    boolean         isUsernameAvailable;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_daftar);
        kon = new volunteerKoneksi(this);

        isUsernameAvailable = false;

        blnSpinner = (Spinner) findViewById(R.id.blnSpinner);
        List<String> categories = new ArrayList<String>(Arrays.asList("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus",
                "September", "Oktober", "November","Desember"));

        // Creating adapter for spinner
        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, categories);

        // Drop down layout style - list view with radio button
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // attaching data adapter to spinner
        blnSpinner.setAdapter(dataAdapter);
        pendidikanRadioGroup = (RadioGroup) findViewById(R.id.ePendidikan);

        pendidikanDipilih = "SD";
        pendidikanRadioGroup.setOnCheckedChangeListener(new RadioGroup.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(RadioGroup radioGroup, int i) {
                String a = "";
                if(i==R.id.SD) {
                    a = "SD";
                }else if(i==R.id.SMP) {
                    a = "SMP";
                }else if(i==R.id.SMA){
                    a = "SMA";
                }else if(i==R.id.S1){
                    a = "S1";
                }else if(i==R.id.S2){
                    a = "S2";
                }else{
                    a = "S3";
                }
                pendidikanDipilih = a;
            }
        });

        nama = (EditText) findViewById(R.id.eNama);
        alamat=(EditText) findViewById(R.id.eAlamat);
//      pendidikan=(EditText) findViewById(R.id.ePendidikan);
        tempat_lahir=(EditText) findViewById(R.id.eTempatLahir);
        username=(EditText) findViewById(R.id.eUsername);
        password=(EditText) findViewById(R.id.ePassword);
        _tgl = (EditText) findViewById(R.id._tgl);
        _thn = (EditText) findViewById(R.id._thn);
        no_hp =(EditText) findViewById(R.id.telephone);
        email =(EditText) findViewById(R.id.email);
        bDaftar = (Button) findViewById(R.id.b_daftar);

        username.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (!hasFocus) {
                    Toast.makeText(DaftarActivity.this, "Mengecek username...", Toast.LENGTH_SHORT).show();
                    if(username.length()>0){kon.isPendonorAvailable(username.getText().toString());};
                }
            }
        });

        bDaftar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(nama.length()>0 && alamat.length()>0 && tempat_lahir.length()>0
                        && username.length()>0 && password.length()>0 && _tgl.length()>0
                        && _thn.length()>0 && no_hp.length()>0 && email.length()>0)
                {
                    if(validateData(nama.getText().toString().trim(),
                                 alamat.getText().toString().trim(),
                                 tempat_lahir.getText().toString().trim(),
                                 username.getText().toString().trim(),
                                 password.getText().toString().trim(),
                                 _tgl.getText().toString().trim(),
                                 _thn.getText().toString().trim(),
                                 no_hp.getText().toString().trim(),
                                 email.getText().toString().trim())){
//                        Toast.makeText(DaftarActivity.this, "DATA VALID", Toast.LENGTH_SHORT).show();
                        kon.registerPendonor(username.getText().toString().trim(),
                                             password.getText().toString().trim(),
                                             nama.getText().toString().trim(),
                                pendidikanDipilih,
                                             alamat.getText().toString().trim(),
                                             tempat_lahir.getText().toString().trim(),
                                             (_thn.getText().toString().trim() + "-" + String.valueOf(1+blnSpinner.getSelectedItemPosition()) + "-" + _tgl.getText().toString().trim()),
                                             "1990-10-10",
                                             no_hp.getText().toString().trim(),
                                             email.getText().toString().trim());
                    }
                }else{
                    Toast.makeText(DaftarActivity.this, "Gak boleh ada yang kosong", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    void toast(String s){Toast.makeText(this, s, Toast.LENGTH_SHORT).show();}

    boolean validateData(String nama, String alamat, String tempat_lahir, String username, String password, String tgl, String thn,
                         String no_hp, String email){
        if(!nama.matches("([A-z']+)(\\s[A-z']+)*")){toast("Nama tidak benar");return false;}
        if(!username.matches("[A-z0-9_\\.]+")){toast("Karakter yang dibolehkan di username: a-Z,0-9,_");return false;}
        if(!password.matches(".{6,}")){toast("Password minimal 6 karakter");return false;}
        if(!alamat.matches(".{3,}")){toast("Alamat minimal 3 karakter");return false;}
        if(!tgl.matches(".{1,2}") || Integer.parseInt(tgl)>31 || Integer.parseInt(tgl)<1 ){toast("Tanggal tidak valid");return false;}
        if(!thn.matches(".{4}") || Integer.parseInt(thn)>2018 || Integer.parseInt(thn)<1900){toast("Tahun tidak valid");return false;}
        if(!no_hp.matches(".{12,}")){toast("Nomer HP tidak valid");return false;}
        return true;
    }


    public void daftarSuccess(){
        Intent i = new Intent(this, LoginActivity.class);
        i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(i);
        finish();
    }
}
