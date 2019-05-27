package com.unsil.if16.volunteer;

import android.os.Handler;
import android.util.Log;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

public class volunteerKoneksi {

    String ipAddress = "http://192.168.100.156";
    Handler h;

    LoginActivity la;
    EventDetailActivity eda;
    DaftarActivity da;
    EventListActivity ela;

    final static int VALIDATE_VOLUNTEER = 0;
    final static int LIST_EVENT = 1;
    final static int IS_PENDONOR_AVAILABLE = 2;
    final static int REGISTER_USER = 3;
    final static int CEK_PARTISIPAN = 4;
    final static int IKUT_PARTISI = 5;
    final static int BATAL_PARTISI = 6;

    public volunteerKoneksi(LoginActivity la) {
        h = new Handler();
        this.la = la;
    }

    public volunteerKoneksi(EventDetailActivity eda) {
        h = new Handler();
        this.eda = eda;
    }

    public volunteerKoneksi(DaftarActivity da){
        h = new Handler();
        this.da = da;
    }
    public volunteerKoneksi(EventListActivity ela)
    {
        h = new Handler();
        this.ela = ela;
    }

    void validatevolunteer(String username, String password) {
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("method", "validate");
            jsonParam.put("username", username);
            jsonParam.put("password", password);
        }catch (JSONException e){
            e.printStackTrace();
        }
        konek_post(VALIDATE_VOLUNTEER,"/volunteer/api/volunteer.php",jsonParam, null);
    }

    void isPendonorAvailable(String username) {
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("method", "available");
            jsonParam.put("username", username);
        }catch (JSONException e){
            e.printStackTrace();
        }
        konek_post(IS_PENDONOR_AVAILABLE,"/volunteer/api/volunteer.php", jsonParam, null);
    }

    public void batalPartisi(String id, String token){
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("method", "delete");
            jsonParam.put("id", id);
        }catch (JSONException e){
            e.printStackTrace();
        }
        Log.i("JSONN", jsonParam.toString());
        konek_post(BATAL_PARTISI,"/volunteer/api/partisipan.php", jsonParam, token);
    }

    public void batalPartisi(String id_event, String id_pendonor, String token){
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("method", "delete");
            jsonParam.put("id_event", id_event);
            jsonParam.put("id_volunteer", id_pendonor);
        }catch (JSONException e){
            e.printStackTrace();
        }
        Log.i("JSONN", jsonParam.toString());
        konek_post(BATAL_PARTISI,"/volunteer/api/partisipan.php", jsonParam, token);
    }

    public void checkPartisipan(String id_event, String id_pendonor, String token)
    {
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("method", "check");
            jsonParam.put("id_event", id_event);
            jsonParam.put("id_volunteer", id_pendonor);
        }catch (JSONException e){
            e.printStackTrace();
        }
        konek_post(CEK_PARTISIPAN, "/volunteer/api/partisipan.php", jsonParam, token);
    }

    public void ikutPartisi(String id_event, String id_pendonor, String token){
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("id_event", id_event);
            jsonParam.put("id_volunteer", id_pendonor);
        }catch (JSONException e){
            e.printStackTrace();
        }
        konek_post(IKUT_PARTISI, "/volunteer/api/partisipan.php", jsonParam, token);
    }

    public void registerPendonor(String username, String password, String nama, String pendidikan,
                          String alamat, String tempat_lahir, String tgl_lahir, String tgl_daftar,
                          String berat_badan, String tinggi_badan){
        JSONObject jsonParam = new JSONObject();
        try {
            jsonParam.put("username", username);
            jsonParam.put("password", password);
            jsonParam.put("nama", nama);
            jsonParam.put("pendidikan", pendidikan);
            jsonParam.put("alamat", alamat);
            jsonParam.put("tempat_lahir", tempat_lahir);
            jsonParam.put("tgl_lahir", tgl_lahir);
            jsonParam.put("email", tinggi_badan);
            jsonParam.put("no_hp", berat_badan);
            jsonParam.put("tgl_daftar", "2018-05-06");
        }catch (JSONException e){e.printStackTrace();}
        konek_post(REGISTER_USER,"/volunteer/api/volunteer.php", jsonParam, null);
    }

    public void listEvent(String token) {
        konek_get(LIST_EVENT,"/myblood/api/event.php", token);
    }

    void eventDetail() {
    }

    void konek_get(final int koneksi_code, final String add, final String token) {
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    String link = "http://" + ipAddress + add;
                    URL url = new URL(link);
                    URLConnection con = url.openConnection();
                    con.addRequestProperty("X-Authorization", "Bearer " + token);
                    con.connect();
                    InputStream is = con.getInputStream();
                    final BufferedReader reader = new BufferedReader(new InputStreamReader
                                                                             (is, "UTF-8"));
                    String data = null;
                    String webPage = "";
                    while ((data = reader.readLine()) != null) {
                        webPage += data;
                    }
                    final String wp = webPage;
                    h.post(new Runnable() {
                        @Override
                        public void run() {
                            //                            Toast.makeText("hehe", wp, Toast.LENGTH_LONG).show();
                            //                            Toast.makeText(getApplicationContext(),wp,Toast.LENGTH_LONG).show();
                            try {
                                JSONObject jsonObject = new JSONObject(wp);
                                ela.loadEvent(jsonObject);
                                JSONArray records = new JSONArray(jsonObject.getString("records"));
                                //                                Toast.makeText(MainActivity.this, String.valueOf(records.length()), Toast.LENGTH_SHORT).show();
                                //---print out the content of the   json feed---
                                String a = "";
//                                Toast.makeText(MainActivity.this, String.valueOf(records.length()), Toast.LENGTH_SHORT).show();
                                for (int i = 0; i < records.length(); i++) {

                                    JSONObject postalCodesItem = records.getJSONObject(i);
                                    //                                    Toast.makeText(MainActivity.this,
                                    //                                                   postalCodesItem.getString("id") + " - " +
                                    //                                                           postalCodesItem.getString("username") + ", " +
                                    //                                                           postalCodesItem.getString("password"),
                                    //                                                   Toast.LENGTH_LONG).show();
                                }
                            }catch (JSONException e){
                                e.printStackTrace();
                            }
                        }
                    });

                }catch (MalformedURLException e) {
                    //e.printStackTrace();
                    e.printStackTrace();
                    if(koneksi_code==LIST_EVENT){h.post(new Runnable() {
                        @Override
                        public void run() {
                            ela.cancelLoadingProgressDialog();
                        }
                    });}
                }
                catch (IOException e) {
                    if(koneksi_code==LIST_EVENT){h.post(new Runnable() {
                        @Override
                        public void run() {
                            ela.cancelLoadingProgressDialog();
                        }
                    });}
                    e.printStackTrace();
                }
            }
        }).start();
    }


    private void konek_post(final int koneksi_code, final String add, final JSONObject json, final String token)
    {
        new Thread(new Runnable() {
            @Override
            public void run() {
                try{
                    h.post(new Runnable() {
                        @Override
                        public void run() {
                            if(koneksi_code== VALIDATE_VOLUNTEER) {
                                la.showLoginProgressDialog();
                            }
                        }
                    });
                    URL url = new URL("http://" + ipAddress + add);
                    HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                    conn.setRequestMethod("POST");
                    conn.setRequestProperty("Content-Type", "application/json;charset=UTF-8");
                    conn.setRequestProperty("Accept","application/json");
                    conn.setRequestProperty("X-Authorization", "Bearer " + token);
                    conn.setDoOutput(true);
                    conn.setDoInput(true);

                    Log.i("JSON", json.toString());
                    DataOutputStream os = new DataOutputStream(conn.getOutputStream());
                    //os.writeBytes(URLEncoder.encode(jsonParam.toString(), "UTF-8"));
                    os.writeBytes(json.
                            toString());

                    os.flush();
                    os.close();

                    Log.i("STATUS", String.valueOf(conn.getResponseCode()));
                    Log.i("MSG" , conn.getResponseMessage());
                    InputStream is = conn.getInputStream();
                    final BufferedReader reader = new BufferedReader(new InputStreamReader
                                                                             (is, "UTF-8"));
                    String data = null;
                    String webPage = "";
                    while ((data = reader.readLine()) != null) {
                        webPage += data;
                    }
                    final String wp = webPage;
                    h.post(new Runnable() {
                        @Override
                        public void run() {
//                            Toast.makeText(la, wp, Toast.LENGTH_SHORT).show();
                        }
                    });
                    String status_msg ="STATUS: " + String.valueOf(conn.getResponseCode()) + "\nMESSAGE: " + conn.getResponseMessage();
                    try {
                        Log.i("RESPONSE", wp);
                        final JSONObject jso = new JSONObject(wp);
                        h.post(new Runnable() {
                            @Override
                            public void run() {
                                try {
//                                    Toast.makeText(la, jso.getString("status"), Toast.LENGTH_LONG).show();
                                    if(koneksi_code== VALIDATE_VOLUNTEER) {
                                        String status = jso.getString("status");
                                        if (status.equals("authenticated")) {
                                            la.loginSuccess(jso.getString("id"), jso.getString("token"));
                                        }
                                        else {
                                            Toast.makeText(la, "Login gagal", Toast.LENGTH_LONG).show();
                                        }
                                        la.cancelLoginProgressDialog();
                                    }else if(koneksi_code==IS_PENDONOR_AVAILABLE) {
                                        String status = jso.getString("status");
                                        if(status.equals("available")){
                                            da.isUsernameAvailable = false;
                                            Toast.makeText(da, "Username sudah ada", Toast.LENGTH_SHORT).show();
                                        }else{
                                            da.isUsernameAvailable = true;
                                            Toast.makeText(da, "Username bisa digunakan", Toast.LENGTH_SHORT).show();
                                        }
                                    }else if(koneksi_code==REGISTER_USER){
//                                        Toast.makeText(da, wp, Toast.LENGTH_SHORT).show();
                                        String status = jso.getString("status");
                                        Toast.makeText(da, "RESPONSE: " + wp, Toast.LENGTH_SHORT).show();
                                        if(status.equals("data_inserted"))
                                        {
                                            Toast.makeText(da, "Daftar berhasil", Toast.LENGTH_SHORT).show();
                                            da.daftarSuccess();
                                        }else {
                                            Toast.makeText(da, "Daftar gagal", Toast.LENGTH_SHORT).show();
                                        }
                                    }else if(koneksi_code==CEK_PARTISIPAN)
                                    {
//                                        JSONArray jsonArray = json.getJSONArray("records");
                                        String status = jso.getString("status");
//                                        Toast.makeText(eda, wp, Toast.LENGTH_SHORT).show();
                                        if (status.equals("found")) {
                                            String no_registrasi = jso.getString("no_registrasi");
                                            String id = jso.getString("id");
//                                            Toast.makeText(eda, "Found", Toast.LENGTH_SHORT).show();
                                            eda.cekPartisipanSuccess(false, no_registrasi, id);
                                        }
                                        else {
//                                            Toast.makeText(eda, "Not found", Toast.LENGTH_LONG).show();
                                            eda.cekPartisipanSuccess(true, null, null);
                                        }
                                    }else if(koneksi_code==IKUT_PARTISI)
                                    {
                                        String status = jso.getString("status");
                                        if(status.equals("data_inserted"))
                                        {
                                            String no_registrasi = jso.getString("no_registrasi");
                                            eda.ikutPartisiSuccess(no_registrasi);
                                        }else{

                                        }
                                    }else if(koneksi_code==BATAL_PARTISI)
                                    {
                                        String status = jso.getString("status");
                                        if(status.equals("delete_success"))
                                        {
                                            eda.batalPartisiSukses();
                                        }else{
                                            eda.cancelLoadingProgressDialog();
                                        }
                                    }
                                }catch (JSONException e){
                                    e.printStackTrace();
                                }
                            }
                        });
                    }catch (JSONException e){
                        e.printStackTrace();
                    }

                }catch (IOException e){
                    e.printStackTrace();
                    h.post(new Runnable() {
                        @Override
                        public void run() {
                            if(koneksi_code== VALIDATE_VOLUNTEER) {
                                la.cancelLoginProgressDialog();
                            }
                        }
                    });
                }
            }
        }).start();
        }
}