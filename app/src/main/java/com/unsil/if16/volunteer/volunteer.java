package com.unsil.if16.volunteer;

class volunteer {
    String nama, alamat, pendidikan, tempat_lahir, tgl_lahir, tgl_masuk, username, password;
    int no_hp, email, id;

    public volunteer(String nama, String alamat, String pendidikan, String tempat_lahir, String tgl_lahir, String tgl_masuk, String username, String password, int email, int telephone){
        this.nama=nama;
        this.alamat=alamat;
        this.pendidikan=pendidikan;
        this.tempat_lahir=tempat_lahir;
        this.tgl_lahir=tgl_lahir;
        this.tgl_masuk=tgl_masuk;
        this.username=username;
        this.password=password;
        this.no_hp=telephone;
        this.email=email;
        this.id=id;
    }

    public String getNama(){
        return this.nama;
    }

    public String getAlamat(){
        return this.alamat;
    }

    public String getPendidikan(){
        return this.pendidikan;
    }

    public String getTempat_lahir(){
        return this.tempat_lahir;
    }

    public String getTgl_lahir(){
        return this.tgl_lahir;
    }

    public String getTgl_masuk() {
        return tgl_masuk;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    public int getNo_hp() {
        return no_hp;
    }

    public int getEmail() {
        return email;
    }

    public int getId() {
        return id;
    }
}
