package com.unsil.if16.volunteer;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Space;
import android.widget.TextView;

import com.google.zxing.WriterException;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import androidmads.library.qrgenearator.QRGContents;
import androidmads.library.qrgenearator.QRGEncoder;

public class EventDetailActivity extends AppCompatActivity {

       String token;
       String nama_event;
       String deskripsi;
       String tempat;
       String tgl_event_dibuat;
       String tgl_event;
       String kuota;
       String banner;
       String id_event;
       String id_volunteer;
       String id_partisipan;
       ImageView bannerEvent;
       TextView namaEvent;
       TextView tempatEvent;
       TextView tanggalEvent;
       TextView deskripsiEvent;
       ProgressDialog pd;
       volunteerKoneksi kon;
       TextView judul;
       boolean belumIkut;
       Menu menu;
       LinearLayout registeredBanner;
       TextView noRegTV;
       Space space;

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_detail_event, menu);
        this.menu = menu;
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
        case R.id.m_ikut:
            if(belumIkut) {
                ikutEvent();
            }else{
                batalPartisi();
            }
            break;
        case android.R.id.home:
            this.finish();
            break;
        default:
            break;
        }
        return true;
    }

    @Override
    public boolean onSupportNavigateUp(){
        finish();
        return true;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_event_detail);

        kon = new volunteerKoneksi(this);

//      namaEvent = (TextView) findViewById(R.id.nama);
        tempatEvent = (TextView) findViewById(R.id.tempat_event);
        tanggalEvent = (TextView) findViewById(R.id.tgl_event);
        deskripsiEvent = (TextView) findViewById(R.id.deskripsi);
        bannerEvent = (ImageView) findViewById(R.id.banner_event);
        judul = (TextView) findViewById(R.id.judul);
        registeredBanner = (LinearLayout) findViewById(R.id.registered_banner);
        noRegTV =(TextView) findViewById(R.id.no_reg);
        space = (Space) findViewById(R.id.space);

        Intent i = getIntent();
        token = i.getStringExtra("token");
        id_volunteer = i.getStringExtra("id_volunteer");
        id_event = i.getStringExtra("id");
        nama_event = i.getStringExtra("nama");
        deskripsi = i.getStringExtra("deskripsi");
        tempat = i.getStringExtra("tempat");
        tgl_event_dibuat = i.getStringExtra("tgl_event_dibuat");
        tgl_event = i.getStringExtra("tgl_event");
        banner = i.getStringExtra("banner");
        kuota = i.getStringExtra("kuota");

        registeredBanner.setVisibility(View.GONE);
        space.setVisibility(View.GONE);

        setTitle("Rincian event");
        judul.setText(nama_event);
        tempatEvent.setText(tempat);
        tanggalEvent.setText(formatDate(tgl_event));
        deskripsiEvent.setText(deskripsi);
        loadFoto();
        showLoadingProgressDialog("Loading event...");
        kon.checkPartisipan(id_event, id_volunteer, token);
    }

    public void showLoadingProgressDialog(String msg){
        pd = new ProgressDialog(this);
        pd.setIndeterminate(true);
        pd.setCancelable(false);
        pd.setCanceledOnTouchOutside(false);
        pd.setMessage(msg);
        pd.show();
    }

    String formatDate(String unformattedDate)
    {
        String[] bln = {"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "November", "Desember"};
        Matcher m = Pattern.compile("(\\d{4})-(\\d{1,2})-(\\d{1,2})").matcher(unformattedDate);
        while(m.find()) {
            return m.group(3) +" "+ bln[Integer.parseInt(m.group(2))-1] + " "+m.group(1);
        }
        return null;
    }

    public void ikutEvent(){
        showLoadingProgressDialog("Meregistrasi event...");
        kon.ikutPartisi(id_event, id_volunteer, token);
    }

    public void ikutPartisiSuccess(String no_registrasi){
        cancelLoadingProgressDialog();
        belumIkut = false;
        MenuItem menuItem = menu.findItem(R.id.m_ikut);
        menuItem.setTitle("BATAL IKUT");



        LinearLayout ll = new LinearLayout(this);
        ImageView iv = new ImageView(this);
        ll.addView(iv);
        QRGEncoder qrgEncoder = new QRGEncoder(no_registrasi, null, QRGContents.Type.TEXT, 480);
        try {
            // Getting QR-Code as Bitmap
            Bitmap bitmap = qrgEncoder.encodeAsBitmap();
            // Setting Bitmap to ImageView
            iv.setImageBitmap(bitmap);
        } catch (WriterException e) {

        }

            AlertDialog.Builder adb = new AlertDialog.Builder(this);
            adb.setTitle("Registrasi Event berhasil");
            adb.setMessage("Nomor registrasi: " + no_registrasi);
            adb.setView(ll);
            adb.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    dialogInterface.dismiss();
                }
            });

            AlertDialog ad = adb.create();
            ad.show();
            noRegTV.setText(no_registrasi);
        registeredBanner.setVisibility(View.VISIBLE);
        space.setVisibility(View.VISIBLE);
//
//        Intent intent = getIntent();
//        finish();
//        startActivity(intent);
    }

    public void cekPartisipanSuccess(boolean b, String no_registrasi, String id){
        belumIkut = b;
        MenuItem menuItem = menu.findItem(R.id.m_ikut);
        if (belumIkut) {
            menuItem.setTitle("IKUT");
        } else {
            registeredBanner.setVisibility(View.VISIBLE);
            space.setVisibility(View.VISIBLE);
            noRegTV.setText(no_registrasi);
            menuItem.setTitle("BATAL IKUT");
            id_partisipan = id;
        }
//        if(!(no_registrasi==null))Toast.makeText(this, "NO REGISTRASI: " + no_registrasi, Toast.LENGTH_SHORT).show();
        cancelLoadingProgressDialog();
    }

    public void batalPartisi()
    {
        showLoadingProgressDialog("Membatalkan registrasi...");
        kon.batalPartisi(id_event, id_volunteer, token);
    }

    public void batalPartisiSukses(){
        cancelLoadingProgressDialog();
//        restartActivity();
        registeredBanner.setVisibility(View.GONE);
        space.setVisibility(View.GONE);
        MenuItem menuItem = menu.findItem(R.id.m_ikut);
        menuItem.setTitle("IKUT");
        belumIkut = true;
    }

    public void restartActivity(){
                Intent intent = getIntent();
                finish();
                startActivity(intent);
    }

    public void cancelLoadingProgressDialog()
    {
        pd.cancel();
    }

    void loadFoto(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    //            ImageView i = (ImageView)findViewById(R.id.image);
                    final Bitmap bitmap = BitmapFactory.decodeStream((InputStream)
                                                                             new URL("https://127.168.100.14/myblood/" + banner).getContent());

                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            bannerEvent.setImageBitmap(bitmap);
//                            cancelLoadingProgressDialog();
                        }
                    });
                } catch (MalformedURLException e) {
                    e.printStackTrace();
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
//                            cancelLoadingProgressDialog();
                        }
                    });
                } catch (IOException e) {
                    e.printStackTrace();
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
//                            cancelLoadingProgressDialog();
                        }
                    });
                }
            }
        }).start();
    }
}
