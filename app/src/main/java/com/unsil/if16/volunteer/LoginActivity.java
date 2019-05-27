package com.unsil.if16.volunteer;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class LoginActivity extends Activity {

    EditText eUsername;
    EditText ePassword;
    Button bLogin;
    volunteerKoneksi kon;
    TextView bDaftar;
    ProgressDialog loginProcessDialog;
    TextView judulApp;
    ImageView qrCode;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        kon = new volunteerKoneksi(this);
        qrCode = (ImageView) findViewById(R.id.bloodimg);


        Typeface myfont = Typeface.createFromAsset(getAssets(),"fonts/proxima_nova_regular.ttf");
        Typeface myfontSemiBold = Typeface.createFromAsset(getAssets(),"fonts/proxima_nova_semibold.ttf");
        Typeface myfontBold = Typeface.createFromAsset(getAssets(),"fonts/proxima_nova_bold.ttf");

        judulApp = (TextView) findViewById(R.id.judulApp);
        judulApp.setTypeface(myfontBold);

        eUsername = (EditText) findViewById(R.id.username);
        ePassword =(EditText) findViewById(R.id.password);
        bLogin = (Button) findViewById(R.id.b_login);
        bDaftar = (TextView) findViewById(R.id.b_daftar);
        bLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(eUsername.length()==0 || ePassword.length()==0) {
                    Toast.makeText(LoginActivity.this, "Ada yang kosong", Toast.LENGTH_LONG).show();
                }else {
                    if (isUsernameValid(eUsername.getText().toString()) && isPasswordValid(ePassword.getText().toString())) {
                        validate(eUsername.getText().toString(), ePassword.getText().toString());
                    }
                }
            }
        });
        bDaftar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getApplicationContext(), DaftarActivity.class);
                startActivity(i);
            }
        });
    }

    boolean isUsernameValid(String username) {
        return true;
    }

    boolean isPasswordValid(String password){
        return true;
    }

    boolean validate(String username, String password){
        kon.validatevolunteer(username,password);
        return true;
    }

    public void loginSuccess(String id, String token)
    {
        Intent i = new Intent(this,EventListActivity.class);
        i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        i.putExtra("username", eUsername.getText().toString());
        i.putExtra("id_volunteer", id);
        i.putExtra("token", token);
        //Toast.makeText(this, "token: " + token, Toast.LENGTH_SHORT).show();
        startActivity(i);
        finish();
    }

    public void showLoginProgressDialog(){
        loginProcessDialog = new ProgressDialog(this);
        loginProcessDialog.setIndeterminate(true);
        loginProcessDialog.setCancelable(false);
        loginProcessDialog.setCanceledOnTouchOutside(false);
        loginProcessDialog.setMessage("Login...");
        loginProcessDialog.show();
    }

    public void cancelLoginProgressDialog()
    {
        loginProcessDialog.cancel();
    }

//    public void ngirimToken(){
//        new Thread(new Runnable() {
//            @Override
//            public void run() {
//
//            }
//        }).start();
//    }
}
