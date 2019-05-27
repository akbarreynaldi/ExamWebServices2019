package com.unsil.if16.volunteer;

import android.net.http.AndroidHttpClient;
import android.os.Build;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.HttpClientStack;
import com.android.volley.toolbox.HttpHeaderParser;
import com.android.volley.toolbox.HttpStack;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {
    TextView tv;
    Button   btGet;
    Button   btPost;
    Button   btDelete;
    EditText deleteParam;
    String ipAddress = "192.168.100.156";

//    public String readJSONFeed(String URL) {
//        StringBuilder stringBuilder = new StringBuilder();
//        HttpClient httpClient = new DefaultHttpClient();
//        HttpGet httpGet = new HttpGet(URL);
//        try {
//            HttpResponse response = httpClient.execute(httpGet);
//            StatusLine statusLine = response.getStatusLine();
//            int statusCode = statusLine.getStatusCode();
//            if (statusCode == 200) {
//                HttpEntity entity = response.getEntity();
//                InputStream inputStream = entity.getContent();
//                BufferedReader reader = new BufferedReader(
//                        new InputStreamReader(inputStream));
//                String line;
//                while ((line = reader.readLine()) != null) {
//                    stringBuilder.append(line);
//                }
//                inputStream.close();
//            } else {
//                Log.d("JSON", "Failed to download file");
//            }
//        } catch (Exception e) {
//            Log.d("readJSONFeed", e.getLocalizedMessage());
//        }
//        return stringBuilder.toString();
//    }
//
//    private class ReadWeatherJSONFeedTask extends AsyncTask<String, Void, String> {
//        protected String doInBackground(String... urls) {
//            return readJSONFeed(urls[0]);
//        }
//
//        protected void onPostExecute(String result) {
//            try {
//                JSONObject jsonObject = new JSONObject(result);
//                JSONObject weatherObservationItems =
//                        new JSONObject(jsonObject.getString("weatherObservation"));
//
//                Toast.makeText(getBaseContext(),
//                               weatherObservationItems.getString("clouds") +
//                                       " - " + weatherObservationItems.getString("stationName"),
//                               Toast.LENGTH_SHORT).show();
//            } catch (Exception e) {
//                Log.d("ReadWeatherJSONFeedTask", e.getLocalizedMessage());
//            }
//        }
//    }
//
//    private class ReadPlacesFeedTask extends AsyncTask
//                                                     <String, Void, String> {
//        protected String doInBackground(String... urls) {
//            return readJSONFeed(urls[0]);
//        }
//
//        protected void onPostExecute(String result) {
//            try {
//                JSONObject jsonObject = new JSONObject(result);
//                JSONArray postalCodesItems = new
//                        JSONArray(jsonObject.getString("records"));
//
//                //---print out the content of the json feed---
//                for (int i = 0; i < postalCodesItems.length(); i++) {
//                    JSONObject postalCodesItem =
//                            postalCodesItems.getJSONObject(i);
//                    Toast.makeText(getBaseContext(),
//                                   postalCodesItem.getString("records") + " - " +
//                                           postalCodesItem.getString("id") + ", " +
//                                           postalCodesItem.getString("nama"),
//                                   Toast.LENGTH_SHORT).show();
//                }
//            } catch (Exception e) {
//                Log.d("ReadPlacesFeedTask", e.getLocalizedMessage());
//            }
//        }
//    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        tv = (TextView)findViewById(R.id.teks);
        btGet = (Button) findViewById(R.id.btGet);
        btPost = (Button) findViewById(R.id.btPost);
        btDelete = (Button) findViewById(R.id.btDelete);
        deleteParam = (EditText) findViewById(R.id.deleteParam);

//        new ReadWeatherJSONFeedTask().execute("http://192.168.1.21/myblood/api/pendonor.php");
//        new ReadPlacesFeedTask().execute("http://192.168.1.21/myblood/api/pendonor.php");

        btPost.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                postJson();
            }
        });

        btGet.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) { getJson(); }
        });

        btDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String delPar = deleteParam.getText().toString();
                if(delPar.length()>0){deleteJson(Integer.parseInt(delPar));}else{
                    Toast.makeText(MainActivity.this, "Delete_parameter_cannot_be_empty", Toast.LENGTH_SHORT).show();
                };
            }
        });
    }

    void getJson(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    String link = "http://" + ipAddress + "/volunteer/api/volunteer.php";
                    URL url = new URL(link);
                    URLConnection con = url.openConnection();
                    con.setConnectTimeout(10000);
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
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            //                            Toast.makeText("hehe", wp, Toast.LENGTH_LONG).show();
                            //                            Toast.makeText(getApplicationContext(),wp,Toast.LENGTH_LONG).show();
                            try {
                                JSONObject jsonObject = new JSONObject(wp);
                                JSONArray records = new JSONArray(jsonObject.getString("records"));
                                //                                Toast.makeText(MainActivity.this, String.valueOf(records.length()), Toast.LENGTH_SHORT).show();
                                //---print out the content of the   json feed---
                                String a = "";
                                Toast.makeText(MainActivity.this, String.valueOf(records.length()), Toast.LENGTH_SHORT).show();
                                for (int i = 0; i < records.length(); i++) {

                                    JSONObject postalCodesItem = records.getJSONObject(i);
//                                    Toast.makeText(MainActivity.this,
//                                                   postalCodesItem.getString("id") + " - " +
//                                                           postalCodesItem.getString("username") + ", " +
//                                                           postalCodesItem.getString("password"),
//                                                   Toast.LENGTH_LONG).show();
                                    a="";
                                    a+="id: " + postalCodesItem.getString("id");
                                    a+="username: " + postalCodesItem.getString("username");
                                    a+="password: " + postalCodesItem.getString("password");
                                    a+="\n";
                                    final String b = a;
                                    runOnUiThread(new Runnable() {
                                        @Override
                                        public void run() {
                                            tv.setText(wp);
                                        }
                                    });
                                }
                            }catch (JSONException e){
                                e.printStackTrace();
                            }
                        }
                    });

                }catch (MalformedURLException e) {
                    //e.printStackTrace();
                    e.printStackTrace();
                }
                catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }).start();
    }

    void postJson(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                try{
                    URL url = new URL("http://" + ipAddress + "/volunteer/api/volunteer.php");
                    HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                    conn.setRequestMethod("POST");
                    conn.setRequestProperty("Content-Type", "application/json;charset=UTF-8");
                    conn.setRequestProperty("Accept","application/json");
                    conn.setDoOutput(true);
                    conn.setDoInput(true);

                    JSONObject jsonParam = new JSONObject();
                    jsonParam.put("username", "ugi");
                    jsonParam.put("password", "123456");
                    jsonParam.put("nama", "ugi");
                    jsonParam.put("pendidikan", "S1");
                    jsonParam.put("alamat", "kuningan");
                    jsonParam.put("tempat_lahir", "kuningan");
                    jsonParam.put("tgl_lahir", "2019-05-30");
                    jsonParam.put("email", "ugi@gmai.com");
                    jsonParam.put("no_hp", "2147483647");
                    jsonParam.put("tgl_daftar", "2019-05-26");


                    Log.i("JSON", jsonParam.toString());
                    DataOutputStream os = new DataOutputStream(conn.getOutputStream());
                    //os.writeBytes(URLEncoder.encode(jsonParam.toString(), "UTF-8"));
                    os.writeBytes(jsonParam.toString());

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
                    String status_msg ="STATUS: " + String.valueOf(conn.getResponseCode()) + "\nMESSAGE: " + conn.getResponseMessage();
                    tv.setText(status_msg);
                    conn.disconnect();
                }catch (Exception e){
                    e.printStackTrace();
                }
            }
        }).start();
    }

    void deleteJson(int delPar){
        HttpStack httpStack;
        String a = "";
        if (Build.VERSION.SDK_INT > 19){
            httpStack = new CustomHurlStack();
            a = "Enung";
        } else if (Build.VERSION.SDK_INT >= 9 && Build.VERSION.SDK_INT <= 19)
        {
            a = "Saadah";
            httpStack = new OkHttpHurlStack();
        } else {
            a = "Neni";
            httpStack = new HttpClientStack(AndroidHttpClient.newInstance("Android"));
        }
        Toast.makeText(this, a, Toast.LENGTH_SHORT).show();
        RequestQueue requestQueue = Volley.newRequestQueue(this, httpStack);
        String URL = "http://" + ipAddress + "/volunteer/api/volunteer.php";
        final JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("id", delPar);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        JsonObjectRequest deleteRequest = new JsonObjectRequest(Request.Method.DELETE, URL, jsonObject, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                Log.i("onResponse", response.toString());
                tv.setText("RESPONSE: "+response.toString());
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("onErrorResponse", error.toString());
                tv.setText("ERROR: "+error.toString());
            }
        }) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> headers = new HashMap<String, String>();
                // Basic Authentication
                //                String credentials = "gustave@example.com:1234";
                //                String auth = "Basic "
                //                        + Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);
                headers.put("Content-Type", "application/json");
                //                headers.put("Authorization", auth);
                return headers;
            }

            @Override
            protected VolleyError parseNetworkError(VolleyError volleyError) {
                String json;
                if (volleyError.networkResponse != null && volleyError.networkResponse.data != null) {
                    try {
                        json = new String(volleyError.networkResponse.data,
                                          HttpHeaderParser.parseCharset(volleyError.networkResponse.headers));
                    } catch (UnsupportedEncodingException e) {
                        return new VolleyError(e.getMessage());
                    }
                    return new VolleyError(json);
                }
                return volleyError;
            }
        };
        requestQueue.add(deleteRequest);
    }
}
