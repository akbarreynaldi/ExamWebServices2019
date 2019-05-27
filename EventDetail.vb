Imports System.IO
Imports Newtonsoft.Json
Imports System.Net

Public Class EventDetail

    Dim token As String
    Dim id As String
    Dim judul As String
    Dim deskripsi As String
    Dim kuota As String
    Dim banner As String
    Dim tgl_event As String
    Dim tempat As String
    Dim apaEdit As Boolean = False
    Dim url As String = Constants.url
    Dim tanggal As Date
    Dim nama_bulan(11) As String
    Dim partisipan As Integer
    Dim webClient As New System.Net.WebClient
    Dim konn As KoneksiMyBlood
    Dim status As HttpStatusCode = HttpStatusCode.ExpectationFailed



    Dim adminForm As AdminForm

    Public Sub New(token As String, id As String, judul As String, tempat As String, tgl_event As String, deskripsi As String, banner As String, kuota As String, partisipan As Integer)
        nama_bulan(0) = "Januari"
        nama_bulan(1) = "Februari"
        nama_bulan(2) = "Maret"
        nama_bulan(3) = "April"
        nama_bulan(4) = "Mei"
        nama_bulan(5) = "Juni"
        nama_bulan(6) = "Juli"
        nama_bulan(7) = "Agustus"
        nama_bulan(8) = "September"
        nama_bulan(9) = "Oktober"
        nama_bulan(10) = "November"
        nama_bulan(11) = "Desember"

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        konn = New KoneksiMyBlood()
        Me.token = token
        Me.id = id
        Me.judul = judul
        Me.deskripsi = deskripsi
        Me.kuota = kuota
        Me.banner = banner
        Me.tempat = tempat
        Me.tgl_event = tgl_event
        Text = Me.judul
        Me.partisipan = partisipan
        tanggal = Date.Parse(tgl_event)

        namaEvent.Text = judul
        waktuEvent.Text = tanggal.Day.ToString + " " + nama_bulan(tanggal.Month) + " " + tanggal.Year.ToString
        tempatEvent.Text = tempat
        deskripsiEvent.Text = deskripsi
        partisipanLabel.Text = "Kuota: " + kuota + " (" + partisipan.ToString + " pendaftar) Sisa: " + (Integer.Parse(kuota) - partisipan).ToString


        Dim tClient As System.Net.WebClient = New System.Net.WebClient
        Dim tImage As Bitmap = Bitmap.FromStream(New MemoryStream(tClient.DownloadData("http://" + url + "/volunteer/" + banner)))
        PictureBox1.Image = tImage
        ''fileNamePath = System.IO.Path.GetFileName(banner)
    End Sub

    Private Sub EventDetail_Load(sender As Object, e As EventArgs) Handles MyBase.Load

        Dim partisipanJson As String = konn.GetResponse("http://" + url + "/volunteer/api/partisipan.php/" + id, status, token)
        Dim partisipanJo As Linq.JObject
        Dim partisipanRecords As Linq.JToken

        Try
            partisipanJo = Newtonsoft.Json.Linq.JObject.Parse(partisipanJson)
            partisipanRecords = partisipanJo("records")
        Catch ex As Exception
            MessageBox.Show(ex.Message)
        End Try

        ListView1.FullRowSelect = True

        ListView1.Clear()

        ListView1.Columns.Add("No", 30, HorizontalAlignment.Center)
        ListView1.Columns.Add("ID", 30, HorizontalAlignment.Center)
        ListView1.Columns.Add("ID User", 50, HorizontalAlignment.Center)
        ListView1.Columns.Add("Nama", 130, HorizontalAlignment.Left)
        ListView1.Columns.Add("Alamat", 150, HorizontalAlignment.Left)
        ListView1.Columns.Add("Golongan darah", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tempat, tanggal lahir", 120, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tinggi badan", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Berat badan", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tanggal daftar", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("No Registrasi", 100, HorizontalAlignment.Left)

        ListView1.View = View.Details

        Dim m As Integer
        If Not IsNothing(partisipanRecords) Then
            For m = 0 To partisipanRecords.Count - 1 'Loop Through Zodiac Array Items
                ListView1.Items.Add((1 + m)) 'Add Each Zodiac Array Item
                'Add From Sub Item For Each Zodiac Item
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("id").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("id_pendonor").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("nama").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("alamat").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("goldar").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("tempat_lahir").ToString + ", " + partisipanRecords(m)("tgl_lahir").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("tinggi_badan").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("berat_badan").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("tgl_daftar").ToString)
                ListView1.Items(m).SubItems.Add(partisipanRecords(m)("no_registrasi").ToString)
            Next m
        End If
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Close()
    End Sub
End Class
