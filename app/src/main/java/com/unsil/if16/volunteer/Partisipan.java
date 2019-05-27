package com.unsil.if16.volunteer;

public class Partisipan {
    int id, id_event, id_volunteer;
    String tgl_ikut, no_registrasi;

    public Partisipan(int id, int id_event, int id_volunteer, String tgl_ikut, String no_registrasi){
        this.id=id;
        this.id_event=id_event;
        this.id_volunteer=id_volunteer;
        this.tgl_ikut=tgl_ikut;
        this.no_registrasi=no_registrasi;
    }

    public int getId() {
        return id;
    }

    public int getId_event() {
        return id_event;
    }

    public int getId_pendonor() {
        return id_volunteer;
    }

    public String getNo_registrasi() {
        return no_registrasi;
    }

    public String getTgl_ikut() {
        return tgl_ikut;
    }
}
