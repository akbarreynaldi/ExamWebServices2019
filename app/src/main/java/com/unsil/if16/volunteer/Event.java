package com.unsil.if16.volunteer;


public class Event {
    String nama_event, deskripsi, tempat, tgl_event_dibuat, tgl_event, banner;
    int kuota, id;

    public Event(String nama_event, String deskripsi, String tempat, String tgl_event_dibuat, String tgl_event, String banner, int kuota, int id){
        this.nama_event=nama_event;
        this.deskripsi=deskripsi;
        this.tempat=tempat;
        this.tgl_event_dibuat=tgl_event_dibuat;
        this.tgl_event=tgl_event;
        this.kuota=kuota;
        this.banner= banner;
        this.id=id;
    }

    public String getNama_event() {
        return nama_event;
    }

    public String getDeskripsi() {
        return deskripsi;
    }

    public String getTempat() {
        return tempat;
    }

    public String getTgl_event_dibuat() {
        return tgl_event_dibuat;
    }

    public String getTgl_event() {
        return tgl_event;
    }

    public int getKuota() {
        return kuota;
    }

    public int getId() {
        return id;
    }

    public String getBanner() {return banner;}
}
