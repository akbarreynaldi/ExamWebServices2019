Imports System.IO
Imports System.Net
Imports System.Web.Script.Serialization
Imports MyBlood
Imports Newtonsoft.Json

Public Class TambahEditEvent
    Dim id As String
    Dim judul As String
    Dim deskripsi As String
    Dim kuota As String
    Dim banner As String
    Dim tgl_event As String
    Dim tempat As String
    Dim apaEdit As Boolean = False
    Dim token As String

    Dim fileNamePath As String = ""
    Dim url As String = Constants.url
    Private adminForm As AdminForm

    ''Public Sub New(adminForm As AdminForm)
    ''Me.adminForm = adminForm
    ''End Sub ''


    Public Sub New(adminForm As AdminForm, token As String)
        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Me.adminForm = adminForm
        Me.Text = "Tambah Event"
        Me.token = token
    End Sub

    Public Sub New(token As String, adminForm As AdminForm, id As String, judul As String, deskripsi As String, banner As String, tempat As String, tgl_event As String, kuota As String)
        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        apaEdit = True
        Me.token = token
        Me.adminForm = adminForm
        Me.id = id
        Me.judul = judul
        Me.deskripsi = deskripsi
        Me.kuota = kuota
        Me.banner = banner
        Me.tempat = tempat
        Me.tgl_event = tgl_event
        Me.Text = "Edit"

        TextBox1.Text = judul
        TextBox2.Text = tempat
        TextBox3.Text = deskripsi
        ''MessageBox.Show("kuota: " + kuota)
        ''MessageBox.Show("banner: " + banner)
        ''MessageBox.Show("tempat: " + tempat)
        ''MessageBox.Show("id: " + id)
        ''MessageBox.Show("tgl_event: " + tgl_event)
        NumericUpDown1.Value = Integer.Parse(kuota)
        DateTimePicker1.Value = Date.Parse(tgl_event)
        '' MessageBox.Show("http://" + url + "/myblood/" + banner)
        Dim tClient As System.Net.WebClient = New System.Net.WebClient

        ''Dim tImage As Bitmap = Bitmap.FromStream(New MemoryStream(tClient.DownloadData("http://" + url + "/volunteer/" + banner)))
        ''PictureBox1.Image = tImage

        Dim fileName = System.IO.Path.GetFileName(banner)
        Try
            PictureBox1.Image = Image.FromFile("D:\banner\" + fileName)
        Catch ex As OutOfMemoryException
            MessageBox.Show("RAM penuh")
        Catch ex1 As FileNotFoundException
            MessageBox.Show("File Not Found")
        End Try


        fileNamePath = System.IO.Path.GetFileName(banner)
        ''MessageBox.Show(fileNamePath)
    End Sub


    Private Sub Label2_Click(sender As Object, e As EventArgs) Handles Label2.Click

    End Sub

    Private Sub TambahEditEvent_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Me.AllowDrop = True
        Try
            ''Dim filename As String = System.IO.Path.Combine("C:\xampp2\htdocs\myblood\banner\7b8b57e7-333a-40f2-b925-e6479832fa49.jpg")
            ''PictureBox1.Image = Image.FromFile(filename)
        Catch ex As Exception
            ''MessageBox.Show(ex.Message)
        End Try
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        pilihGbr("null")
    End Sub

    Sub pilihGbr(path As String)
        Dim myStream As Stream = Nothing
        Dim openFileDialog1 As New OpenFileDialog()
        Dim namaFile As String = ""

        openFileDialog1.InitialDirectory = "c:\"
        openFileDialog1.Filter = "Gambar (*.jpg *.jpeg *.png *.gif *.bmp)|*.jpg;*.jpeg;.png;*.gif;*.bmp"
        openFileDialog1.FilterIndex = 2
        openFileDialog1.RestoreDirectory = True
        openFileDialog1.Title = "Upload Banner"


        If openFileDialog1.ShowDialog() = System.Windows.Forms.DialogResult.OK Then
            Try
                myStream = openFileDialog1.OpenFile()

                namaFile = openFileDialog1.FileName
                ''MessageBox.Show(namaFile)
                If (myStream IsNot Nothing) Then
                    ' Insert code to read the stream here.
                End If
            Catch Ex As Exception
                MessageBox.Show("Cannot read file from disk. Original error: " & Ex.Message)
            Finally
                ' Check this again, since we need to make sure we didn't throw an exception on open.
                If (myStream IsNot Nothing) Then
                    myStream.Close()
                End If
            End Try
        End If

        If (namaFile IsNot "") Then
            ''My.Computer.Network.UploadFile(namaFile, "http://" + url + "/volunteer/api/upload.php")
            ''adminForm.SetStatus("Upload Success")
            fileNamePath = System.IO.Path.GetFileName(namaFile)
            ''Dim filename As String = System.IO.Path.Combine(namaFile)
            ''PictureBox1.Image = Image.FromFile(filename)
            uploadGbr(namaFile)
        End If
    End Sub

    Sub uploadGbr(path As String)
        Dim namaFile = System.IO.Path.GetFileName(path)
        My.Computer.Network.UploadFile(path, "http://" + url + "/volunteer/api/upload.php")
        adminForm.SetStatus("Upload Success")
        fileNamePath = System.IO.Path.GetFileName(namaFile)
        Dim filename As String = System.IO.Path.Combine(namaFile)
        PictureBox1.Image = Image.FromFile(path)
    End Sub


    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        If TextBox1.TextLength > 0 And TextBox2.TextLength > 0 And TextBox3.TextLength > 0 And fileNamePath IsNot "" Then

            Dim tgl, bln, thn As String
            thn = DateTimePicker1.Value.Year
            bln = DateTimePicker1.Value.Month
            tgl = DateTimePicker1.Value.Day

            Dim eventDonorDarah As New EventDonorDarah()
            eventDonorDarah.judul = TextBox1.Text
            eventDonorDarah.tempat = TextBox2.Text
            eventDonorDarah.deskripsi = TextBox3.Text
            eventDonorDarah.tgl_event = thn + "-" + bln + "-" + tgl
            eventDonorDarah.banner = "./banner/" + fileNamePath
            eventDonorDarah.kuota = NumericUpDown1.Value.ToString()
            If apaEdit Then
                eventDonorDarah.id = id
                eventDonorDarah.method = "update"
            End If

            'Call SeralizeObject to convert the object to JSON string'
            Dim output As String = Newtonsoft.Json.JsonConvert.SerializeObject(eventDonorDarah)
            ''MessageBox.Show(output)
            Dim koneksi As KoneksiMyBlood = New KoneksiMyBlood
            Dim status As HttpStatusCode = HttpStatusCode.ExpectationFailed
            Dim response As Byte() = koneksi.PostResponse("http://" + url + "/volunteer/api/event.php", output, status, token)

            Dim responseString As String

            If response IsNot Nothing Then
                responseString = System.Text.Encoding.UTF8.GetString(response)
            Else
                responseString = "NULL"
            End If

            Dim jss As New JavaScriptSerializer()
            Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(responseString)
            Dim s As String
            s = dict("status")
            If s = "update_success" Or s = "data_inserted" Then
                Me.Close()
                adminForm.SetStatus("Masukkin event sukses")
            Else
                MessageBox.Show("Gagal/Ada Kesalahan")
            End If
            adminForm.loadData()
        Else
            MessageBox.Show("Belum lengkap")
        End If
    End Sub

    Private Sub TambahEditEvent_DragDrop(sender As Object, e As DragEventArgs) Handles MyBase.DragDrop
        Dim files() As String = e.Data.GetData(DataFormats.FileDrop)
        Dim jml_file = (files.Count().ToString())
        If jml_file > 1 Then
            MessageBox.Show("Jangan lebih dari 1 file")
        Else
            For Each path In files
                Dim fileType = System.IO.Path.GetExtension(path).ToLower()
                Dim filePath = path
                If fileType = ".png" Or fileType = ".jpg" Or fileType = ".jpeg" Or fileType = ".gif" Or fileType = ".bmp" Then
                    ''MsgBox("Gambar valid")
                    uploadGbr(filePath)
                Else
                    MsgBox("Bukan file gambar atau gambar tidak valid")
                End If
            Next
        End If
    End Sub

    Private Sub TambahEditEvent_DragEnter(sender As System.Object, e As System.Windows.Forms.DragEventArgs) Handles Me.DragEnter
        If e.Data.GetDataPresent(DataFormats.FileDrop) Then
            e.Effect = DragDropEffects.Copy
        End If
    End Sub

    Private Sub PictureBox1_Click(sender As Object, e As EventArgs) Handles PictureBox1.Click
        pilihGbr("null")
    End Sub

    Private Sub PictureBox1_DoubleClick(sender As Object, e As EventArgs) Handles PictureBox1.DoubleClick
        pilihGbr("null")

    End Sub
End Class

Public Class EventDonorDarah
    ''Dim nama, tempat, deskripsi, tanggal, banner As String

    Public Property id As String
        Get
            Return _id
        End Get
        Set(value As String)
            _id = value
        End Set
    End Property
    Private _id As String

    Public Property judul As String
        Get
            Return _judul
        End Get
        Set(value As String)
            _judul = value
        End Set
    End Property
    Private _judul As String

    Public Property tempat As String
        Get
            Return _tempat
        End Get
        Set(value As String)
            _tempat = value
        End Set
    End Property
    Private _tempat As String

    Public Property deskripsi As String
        Get
            Return _deskripsi
        End Get
        Set(value As String)
            _deskripsi = value
        End Set
    End Property
    Private _deskripsi As String

    Public Property tgl_event As String
        Get
            Return _tgl_event
        End Get
        Set(value As String)
            _tgl_event = value
        End Set
    End Property
    Private _tgl_event As String

    Public Property banner As String
        Get
            Return _banner
        End Get
        Set(value As String)
            _banner = value
        End Set
    End Property
    Private _banner As String

    Public Property kuota As String
        Get
            Return _kuota
        End Get
        Set(value As String)
            _kuota = value
        End Set
    End Property
    Private _kuota As String

    Public Property method As String
        Get
            Return _method
        End Get
        Set(value As String)
            _method = value
        End Set
    End Property
    Private _method As String

End Class
