package com.unsil.if16.volunteer;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class EventListActivity extends AppCompatActivity {

    volunteerKoneksi kon;
    RecyclerView               r_listEvent;
    RecyclerView.LayoutManager mLayoutManager;
    ListEventAdapter           mListEventAdapter;
    List<Event> events = new ArrayList<>();
    ProgressDialog pd;
    String token;

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_list_event, menu);
        return true;
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event)  {
        if (keyCode == KeyEvent.KEYCODE_BACK && event.getRepeatCount() == 0) {
            exitConfirm();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
        case R.id.m_logout:
            Intent i = new Intent(this, LoginActivity.class);
            startActivity(i);
            this.finish();
            break;
        case android.R.id.home:
//            exitConfirm();
        case R.id.m_about:
            showDialog("MyBlood",
                       "Dibuat Mei 2018\n=>Ajeng Shaffira A.\n=>Ardiansah\n=>Ejah Said M.\n=>Ihsan Hasanudin\n=>Ulfah Nuraeni" +
                               "\n\nAPI URL: http://mybloodapi.000webhostapp.com/myblood/api");
        default:
            break;
        }
        return true;
    }

    void showDialog(String title, String message){
        AlertDialog.Builder adb = new AlertDialog.Builder(this);
        adb.setTitle(title);
        adb.setMessage(message);
        adb.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                dialogInterface.dismiss();
            }
        });

        AlertDialog ad = adb.create();
        ad.show();
    }

    @Override
    public boolean onSupportNavigateUp(){
        finish();
        return true;
    }

    String id_volunteer;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_event_list);

        kon = new volunteerKoneksi(this);
        setTitle("Daftar Event");

        id_volunteer = getIntent().getStringExtra("id_volunteer");
        token = getIntent().getStringExtra("token");
        r_listEvent = (RecyclerView) findViewById(R.id.my_recycler_view_event_list);
        mListEventAdapter = new ListEventAdapter(events, new ListEventAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(Event event) {
                //                Toast.makeText(getApplicationContext(), "Item Clicked", Toast.LENGTH_LONG).show();
                Intent i = new Intent(getApplicationContext(), EventDetailActivity.class);
                i.putExtra("id", String.valueOf(event.getId()));
                i.putExtra("id_volunteer", id_volunteer);
                i.putExtra("nama", event.getNama_event());
                i.putExtra("deskripsi", event.getDeskripsi());
                i.putExtra("banner", event.getBanner());
                i.putExtra("tgl_event", event.getTgl_event());
                i.putExtra("tgl_event_dibuat", event.getTgl_event_dibuat());
                i.putExtra("kuota", String.valueOf(event.getKuota()));
                i.putExtra("tempat", event.getTempat());
                i.putExtra("token", token);
                startActivity(i);
            }
        });

        mLayoutManager = new LinearLayoutManager(this);
        r_listEvent.setLayoutManager(mLayoutManager);
        r_listEvent.setItemAnimator(new DefaultItemAnimator());

        r_listEvent.setAdapter(mListEventAdapter);
        kon.listEvent(token);
        showLoadingProgressDialog();
    }

    public void showLoadingProgressDialog(){
        pd = new ProgressDialog(this);
        pd.setIndeterminate(true);
        pd.setCancelable(false);
        pd.setCanceledOnTouchOutside(false);
        pd.setMessage("Loading daftar event...");
        pd.show();
    }

    public void cancelLoadingProgressDialog()
    {
        pd.cancel();
    }

    void exitConfirm()
    {
        AlertDialog.Builder adb = new AlertDialog.Builder(this);
//        adb.setTitle("Keluar");
        adb.setMessage("Yakin mau keluar?");
        adb.setPositiveButton("Iya", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                exit();
            }
        });
        adb.setNegativeButton("Enggak", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                dialogInterface.dismiss();
            }
        });
        adb.setNeutralButton("Logout saja", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                final Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                startActivity(intent);
                exit();
            }
        });

        AlertDialog ad = adb.create();
        ad.show();
    }

    void exit(){
        this.finish();
    }


    public void loadEvent(JSONObject json) throws JSONException {
        JSONArray records = new JSONArray(json.getString("records"));
        //                                Toast.makeText(MainActivity.this, String.valueOf(records.length()), Toast.LENGTH_SHORT).show();
        //---print out the content of the   json feed---
        for (int i = 0; i < records.length(); i++) {
            JSONObject items = records.getJSONObject(i);
            Event event = new Event(items.getString("judul"),items.getString("deskripsi"),
                                    items.getString("tempat"),
                                    "1996-10-10",
                                    items.getString("tgl_event"),
                                    items.getString("banner"),
                                    Integer.parseInt(items.get("kuota").toString()), Integer.parseInt(items.get("id").toString())
                                    );
            events.add(event);
            mListEventAdapter.notifyDataSetChanged();
//            Toast.makeText(this, String.valueOf(i), Toast.LENGTH_SHORT).show();
            //                                    Toast.makeText(MainActivity.this,
            //                                                   postalCodesItem.getString("id") + " - " +
            //                                                           postalCodesItem.getString("username") + ", " +
            //                                                           postalCodesItem.getString("password"),
            //                                                   Toast.LENGTH_LONG).show();
        }
        cancelLoadingProgressDialog();
    }
}
