Imports System.Web.Script.Serialization
Imports Newtonsoft.Json
Imports System.Net.WebClient
Imports System.IO
Imports System.Net

Public Class AdminForm

    Private arrZodiac(11) As String 'Array To Hold Zodiac Signs
    Private arrFrom(11) As String 'Each Zodiac Sign's Starting Date
    Dim koneksi As KoneksiMyBlood = New KoneksiMyBlood
    Dim status As HttpStatusCode = HttpStatusCode.ExpectationFailed

    Dim webClient As New System.Net.WebClient
    Dim url As String = Constants.url
    Dim loginForm As Form1
    Dim token As String

    Public Sub New(loginForm As Form1, token As String)

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Me.loginForm = loginForm
        loginForm.Hide()
        Me.token = token
    End Sub

    Sub LoadImages(url As String)
        ''Try
        ''MessageBox.Show(url)

        ''Dim tClient As System.Net.WebClient = New System.Net.WebClient
        ''Dim tImage As Bitmap = Bitmap.FromStream(New MemoryStream(tClient.DownloadData(url)))
        ''PictureBox1.Image = tImage

        Dim fileName = System.IO.Path.GetFileName(url)
        Try
            PictureBox1.Image = Image.FromFile("D:\banner\" + fileName)
        Catch ex As Exception
            ToolStripStatusLabel1.Text = ex.Message
        Catch ex1 As OutOfMemoryException
            ''MessageBox.Show("RAM HABIS")
        Catch ex2 As IOException
            ''MessageBox.Show("File not found")
        End Try

        ''Catch exc As Exception
        ''MessageBox.Show(exc.Message)
        ''End Try
    End Sub

    Public Sub loadData()
        SetStatus("Loading data...")
        Dim jss As New JavaScriptSerializer()
        ''Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(result)
        ''Dim records As Integer = dict.Count

        ''Dim obj = JsonConvert.DeserializeObject(Of RecordsEvent())(result)

        ''Dim eventJson As String = webClient.DownloadString("http://" + url + "/volunteer/api/event.php")
        ''Dim pendonorJson As String = webClient.DownloadString("http://" + url + "/volunteer/api/pendonor.php")
        ''Dim partisipanJson As String = webClient.DownloadString("http://" + url + "/volunteer/api/partisipan.php")

        Dim eventJson As String = LoadJson("http://" + url + "/volunteer/api/event.php", token)
        Dim pendonorJson As String = LoadJson("http://" + url + "/volunteer/api/pendonor.php", token)
        Dim partisipanJson As String = LoadJson("http://" + url + "/volunteer/api/partisipan.php", token)

        Dim eventJo As Linq.JObject
        Dim eventRecords As Linq.JToken
        Dim pendonorJo As Linq.JObject
        Dim pendonorRecords As Linq.JToken
        Dim pendonorStatistic As Linq.JToken
        Dim partisipanJo As Linq.JObject
        Dim partisipanRecords As Linq.JToken

        Try
            eventJo = Newtonsoft.Json.Linq.JObject.Parse(eventJson)
            eventRecords = eventJo("records")
            pendonorJo = Newtonsoft.Json.Linq.JObject.Parse(pendonorJson)
            pendonorRecords = pendonorJo("records")
            pendonorStatistic = pendonorJo("statistic")
            partisipanJo = Newtonsoft.Json.Linq.JObject.Parse(partisipanJson)
            partisipanRecords = partisipanJo("records")
        Catch ex As Exception
            ''MessageBox.Show(ex.Message)
        End Try

        Dim godarA As String = pendonorStatistic(0)("a").ToString
        Dim godarB As String = pendonorStatistic(0)("b").ToString
        Dim godarAB As String = pendonorStatistic(0)("ab").ToString
        Dim godarO As String = pendonorStatistic(0)("o").ToString

        abLabel.Text = godarAB
        bLabel.Text = godarB
        aLabel.Text = godarA
        oLabel.Text = godarO

        jmlLbale.Text = pendonorRecords.Count.ToString() + " Pendonor"

        Dim gg As Integer
        For gg = 0 To 2 'Loop Through Zodiac Array Items
            ''MessageBox.Show(records(gg)("judul").ToString)
        Next gg

        ''MessageBox.Show(records.ToString())
        ''MessageBox.Show(records)
        ListView1.FullRowSelect = True
        ListView2.FullRowSelect = True

        ListView1.Clear()
        ListView2.Clear()

        ListView1.Columns.Add("No", 30, HorizontalAlignment.Center)
        ListView1.Columns.Add("ID", 30, HorizontalAlignment.Center)
        ListView1.Columns.Add("Nama Event", 130, HorizontalAlignment.Left)
        ListView1.Columns.Add("Deskripsi", 150, HorizontalAlignment.Left)
        ListView1.Columns.Add("Banner", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tempat", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tanggal event dibuat", 100, HorizontalAlignment.Left)
        ListView1.Columns.Add("Tanggal event", 80, HorizontalAlignment.Left)
        ListView1.Columns.Add("Kuota", 50, HorizontalAlignment.Left)
        ListView1.Columns.Add("Partisipan", 50, HorizontalAlignment.Left)

        ListView2.Columns.Add("No", 30, HorizontalAlignment.Center)
        ListView2.Columns.Add("ID", 30, HorizontalAlignment.Center)
        ListView2.Columns.Add("Nama", 100, HorizontalAlignment.Left)
        ListView2.Columns.Add("Alamat", 100, HorizontalAlignment.Left)
        ListView2.Columns.Add("Golongan Darah", 100, HorizontalAlignment.Left)
        ListView2.Columns.Add("Tempat, tanggal lahir", 150, HorizontalAlignment.Left)
        ListView2.Columns.Add("Tanggal daftar", 100, HorizontalAlignment.Left)
        ListView2.Columns.Add("Tinggi Badan", 70, HorizontalAlignment.Left)
        ListView2.Columns.Add("Berat Bedan", 70, HorizontalAlignment.Left)


        ListView1.View = View.Details
        ListView2.View = View.Details

        Dim k As Integer 'Loop Counter
        Dim l As Integer
        Dim m As Integer

        Dim jmlEvent = 0
        Dim jmlPendonor = 0

        Try
            For k = 0 To eventRecords.Count - 1 'Loop Through Zodiac Array Items
                ListView1.Items.Add((1 + k)) 'Add Each Zodiac Array Item
                'Add From Sub Item For Each Zodiac Item
                ListView1.Items(k).SubItems.Add(eventRecords(k)("id").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("judul").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("deskripsi").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("banner").ToString)
                Try
                    My.Computer.Network.DownloadFile("http://" + url + "/volunteer/" + eventRecords(k)("banner").ToString, "D:\banner\" + Path.GetFileName(eventRecords(k)("banner").ToString), False, 500)
                Catch ex As Exception
                    ToolStripStatusLabel1.Text = ex.Message
                End Try
                ListView1.Items(k).SubItems.Add(eventRecords(k)("tempat").ToString)
                    ListView1.Items(k).SubItems.Add(eventRecords(k)("tgl_event_dibuat").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("tgl_event").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("kuota").ToString)
                ListView1.Items(k).SubItems.Add(eventRecords(k)("jml_partisipan").ToString)
                jmlEvent = jmlEvent + 1
                SetStatus(jmlEvent.ToString + " event dimuat...")
            Next k

            For l = 0 To pendonorRecords.Count - 1 'Loop Through Zodiac Array Items
                ListView2.Items.Add((1 + l)) 'Add Each Zodiac Array Item
                'Add From Sub Item For Each Zodiac Item
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("id").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("nama").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("alamat").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("goldar").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("tempat_lahir").ToString + ", " + pendonorRecords(l)("tgl_lahir").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("tgl_daftar").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("tinggi_badan").ToString)
                ListView2.Items(l).SubItems.Add(pendonorRecords(l)("berat_badan").ToString)
                jmlPendonor = jmlPendonor + 1
                SetStatus(jmlPendonor.ToString + " pendonor dibuat...")
            Next l

        Catch ex As Exception
            ''MessageBox.Show(ex.Message)
        End Try
        SetStatus("Data loaded (" + jmlEvent.ToString + " event dan " + jmlPendonor.ToString + " pendonor)")
    End Sub

    Private Sub AdminForm_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        loadData()
        ' Set the caption bar text of the form.  
        Me.Text = "Event"
        Button4.Enabled = False
        Button8.Enabled = False
    End Sub

    Private Sub ListView1_SelectedIndexChanged(sender As Object, e As EventArgs)
        MessageBox.Show("hehe")
    End Sub

    Private Sub TabControl1_SelectedIndexChanged(sender As Object, e As EventArgs) Handles TabControl1.SelectedIndexChanged
        Dim index As Integer
        Dim title As String
        index = TabControl1.SelectedTab.TabIndex

        Select Case index
            Case 0
                title = "Event"
                ''Debug.WriteLine("Between 1 and 5, inclusive")
        ' The following is the only Case clause that evaluates to True.
            Case 1
                title = "Pendonor"
                ''Debug.WriteLine("Between 6 and 8, inclusive")
            Case Else
                title = "Partisipan"
                ''Debug.WriteLine("Not between 1 and 10, inclusive")
        End Select

        Me.Text = title + " - MyBlood (Admin)"
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim TambahEditEvent1 As TambahEditEvent = New TambahEditEvent(Me, token)
        TambahEditEvent1.ShowDialog()
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs)
        Dim TambahEditPendonor1 As TambahEditPendonor = New TambahEditPendonor(Me, token)
        TambahEditPendonor1.ShowDialog()
    End Sub

    Private Sub ListView1_SelectedIndexChanged_1(sender As Object, e As EventArgs) Handles ListView1.SelectedIndexChanged
        ''MessageBox.Show(ListView1.SelectedItems.Count)
        ''MessageBox.Show(ListView1.FocusedItem.Index)
        If (ListView1.SelectedIndices.Count > 0) Then
            If Not Button8.Enabled Then
                Button8.Enabled = True
            End If
            ToolStripStatusLabel1.Text = ListView1.SelectedIndices.Count.ToString + " Event dipilih"
        Else
            If Button8.Enabled Then
                ToolStripStatusLabel1.Text = ""
                Button8.Enabled = False
            End If
        End If
    End Sub

    Private Sub ListView1_ItemSelectionChanged(sender As Object, e As ListViewItemSelectionChangedEventArgs) Handles ListView1.ItemSelectionChanged
        ''MessageBox.Show(e.ToString())
        ''MessageBox.Show(ListView1.FocusedItem.SubItems(3).Text)
        LoadImages("http://" + url + "/myblood/" + ListView1.FocusedItem.SubItems(4).Text)
        namaEvent.Text = ListView1.FocusedItem.SubItems(2).Text
        waktuEvent.Text = ListView1.FocusedItem.SubItems(7).Text
        tempatEvent.Text = ListView1.FocusedItem.SubItems(5).Text
        deskripsiEvent.Text = ListView1.FocusedItem.SubItems(3).Text
        kuotaEvent.Text = ListView1.FocusedItem.SubItems(8).Text
    End Sub

    Private Sub ListView1_MouseDoubleClick(sender As Object, e As MouseEventArgs) Handles ListView1.MouseDoubleClick
        ''MessageBox.Show(ListView1.FocusedItem.SubItems(1).Text + "\n")


        Dim TambahEditEvent1 As TambahEditEvent = New TambahEditEvent(token, Me, ListView1.FocusedItem.SubItems(1).Text, ListView1.FocusedItem.SubItems(2).Text, ListView1.FocusedItem.SubItems(3).Text, ListView1.FocusedItem.SubItems(4).Text, ListView1.FocusedItem.SubItems(5).Text, ListView1.FocusedItem.SubItems(6).Text, ListView1.FocusedItem.SubItems(8).Text)
        ''TambahEditEvent1.ShowDialog()

        Dim id As String = ListView1.FocusedItem.SubItems(1).Text
        Dim judul As String = ListView1.FocusedItem.SubItems(2).Text
        Dim deskripsi = ListView1.FocusedItem.SubItems(3).Text
        Dim kuota = ListView1.FocusedItem.SubItems(8).Text
        Dim banner = ListView1.FocusedItem.SubItems(4).Text
        Dim tempat = ListView1.FocusedItem.SubItems(5).Text
        Dim tgl_event = ListView1.FocusedItem.SubItems(6).Text
        Dim jumlah_partisipan = Integer.Parse(ListView1.FocusedItem.SubItems(9).Text)

        Dim EventDetail1 As EventDetail = New EventDetail(token, id, judul, tempat, tgl_event, deskripsi, banner, kuota, jumlah_partisipan)
        EventDetail1.ShowDialog()

    End Sub



    Private Sub LogoutToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles LogoutToolStripMenuItem.Click
        logout = True
        loginForm.Show()
        loginForm.TextBox2.Text = ""
        Me.Close()
    End Sub

    Dim logout As Boolean = False

    Private Sub AboutToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles AboutToolStripMenuItem.Click
        Dim aboutDialog As AboutDialog = New AboutDialog
        aboutDialog.ShowDialog()
    End Sub

    Private Sub Button7_Click(sender As Object, e As EventArgs) Handles Button7.Click
        loadData()
    End Sub

    Public Sub SetStatus(msg As String)
        ToolStripStatusLabel1.Text = msg
    End Sub

    Private Function LoadJson(url As String, token As String) As String
        Return koneksi.GetResponse(url, status, token)
        ''Dim jss As New JavaScriptSerializer()
        ''Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(responseString)
        ''Dim s As String
        ''s = dict("status")
    End Function


    Private Sub hapusEvent()
        Dim id As String = ListView1.SelectedItems.Count
        Dim id2 As ListView.SelectedIndexCollection = ListView1.SelectedIndices

        Dim sukses = 0
        Dim gagal = 0

        Dim hehe As String = ""
        Dim jml As Integer = id2.Count
        Dim iii As Integer
        For iii = 0 To id2.Count - 1
            SetStatus("Menghapus event...")
            Dim id__ = ListView1.Items.Item(Integer.Parse(id2(iii).ToString)).SubItems(1).Text
            Dim output As String = "{""method"":""delete"",""id"":""" + id__ + """}"
            Dim response As Byte() = koneksi.PostResponse("http://" + url + "/volunteer/api/event.php", output, status, token)
            Dim responseString As String
            If response IsNot Nothing Then
                responseString = System.Text.Encoding.UTF8.GetString(response)
            Else
                responseString = "NULL"
            End If

            Try
                Dim jss As New JavaScriptSerializer()
                Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(responseString)
                Dim s As String
                s = dict("status")
                sukses = sukses + 1
            Catch ex As Exception
                gagal = gagal + 1
            End Try

            ''MessageBox.Show(s)
            ''PictureBox1.Dispose()
        Next iii
        ''MessageBox.Show(ListView1.Items.Item(id3).SubItems(2).ToString)

        MessageBox.Show(sukses.ToString + " data event dihapus, " + gagal.ToString + " tidak diketahui")
        SetStatus(sukses.ToString + " data event dihapus, " + gagal.ToString + " tidak diketahui")
        loadData()
        LoadImages("http://" + url + "/volunteer/" + ListView1.Items.Item(ListView1.Items.Count - 1).SubItems(4).Text)
    End Sub

    Private Sub hapusPendonor()
        Dim id As String = ListView2.SelectedItems.Count
        Dim id2 As ListView.SelectedIndexCollection = ListView2.SelectedIndices

        Dim gagal = 0
        Dim sukses = 0

        Dim hehe As String = ""
        Dim jml As Integer = id2.Count
        Dim iii As Integer
        For iii = 0 To id2.Count - 1
            SetStatus("Menghapus pendonor...")
            Dim id__ = ListView2.Items.Item(Integer.Parse(id2(iii).ToString)).SubItems(1).Text

            Dim output As String = "{""method"":""delete"",""id"":""" + id__ + """}"
            Dim response As Byte() = koneksi.PostResponse("http://" + url + "/volunteer/api/pendonor.php", output, status, token)
            Dim responseString As String
            If response IsNot Nothing Then
                responseString = System.Text.Encoding.UTF8.GetString(response)
            Else
                responseString = "NULL"
            End If
            Try
                Dim jss As New JavaScriptSerializer()
                Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(responseString)
                Dim s As String
                s = dict("status")
                sukses = sukses + 1
            Catch ex As Exception
                gagal = gagal + 1
            End Try
            ''MessageBox.Show(s)
            ''PictureBox1.Dispose()
        Next iii
        SetStatus(sukses.ToString + " data pendonor dihapus, " + gagal.ToString + " tidak diketahui")
        MessageBox.Show(sukses.ToString + " data pendonor dihapus, " + gagal.ToString + " tidak diketahui")
        loadData()
    End Sub

    Private Sub Button8_Click(sender As Object, e As EventArgs) Handles Button8.Click
        hapusEvent()
    End Sub

    Private Sub ToolStripStatusLabel1_Click(sender As Object, e As EventArgs) Handles ToolStripStatusLabel1.Click

    End Sub

    Private Sub AdminForm_FormClosed(sender As Object, e As FormClosedEventArgs) Handles MyBase.FormClosed
        If Not logout Then
            loginForm.Close()
        End If
    End Sub

    Private Sub ContextMenuStrip1_Opening(sender As Object, e As System.ComponentModel.CancelEventArgs) Handles ContextMenuStrip1.Opening
        ToolStripMenuItem1.Text = "Hapus"
        If ListView1.SelectedIndices.Count = 1 Then
            ToolStripMenuItem2.Enabled = True
            ToolStripMenuItem1.Enabled = True
            ToolStripMenuItem1.Text = "Hapus ini"
        ElseIf ListView1.SelectedIndices.Count > 1 Then
            ToolStripMenuItem2.Enabled = False
            ToolStripMenuItem1.Enabled = True
            ToolStripMenuItem1.Text = "Hapus " + ListView1.SelectedIndices.Count.ToString + " Event"
        Else
            ToolStripMenuItem1.Enabled = False
            ToolStripMenuItem2.Enabled = False
        End If
    End Sub

    Private Sub ToolStripMenuItem1_Click(sender As Object, e As EventArgs) Handles ToolStripMenuItem1.Click
        hapusEvent()
    End Sub

    Private Sub ToolStripMenuItem2_Click(sender As Object, e As EventArgs) Handles ToolStripMenuItem2.Click
        Dim TambahEditEvent1 As TambahEditEvent = New TambahEditEvent(token, Me, ListView1.FocusedItem.SubItems(1).Text, ListView1.FocusedItem.SubItems(2).Text, ListView1.FocusedItem.SubItems(3).Text, ListView1.FocusedItem.SubItems(4).Text, ListView1.FocusedItem.SubItems(5).Text, ListView1.FocusedItem.SubItems(6).Text, ListView1.FocusedItem.SubItems(8).Text)
        TambahEditEvent1.ShowDialog()
    End Sub

    Private Sub TabPage1_Click(sender As Object, e As EventArgs) Handles TabPage1.Click

    End Sub

    Private Sub Label4_Click(sender As Object, e As EventArgs) Handles namaEvent.Click

    End Sub

    Private Sub Label4_Click_1(sender As Object, e As EventArgs) Handles Label4.Click

    End Sub

    Private Sub kuotaEvent_Click(sender As Object, e As EventArgs) Handles kuotaEvent.Click

    End Sub

    Private Sub Label7_Click(sender As Object, e As EventArgs) Handles Label7.Click

    End Sub

    Private Sub deskripsiEvent_Click(sender As Object, e As EventArgs) Handles deskripsiEvent.Click

    End Sub

    Private Sub Label2_Click(sender As Object, e As EventArgs) Handles Label2.Click

    End Sub

    Private Sub Label3_Click(sender As Object, e As EventArgs) Handles Label3.Click

    End Sub

    Private Sub ListView2_DoubleClick(sender As Object, e As EventArgs) Handles ListView2.DoubleClick
        editPendonor()
    End Sub

    Private Sub ContextMenuStrip2_Opening(sender As Object, e As System.ComponentModel.CancelEventArgs) Handles ContextMenuStrip2.Opening
        HapusToolStripMenuItem.Text = "Hapus"
        If ListView2.SelectedIndices.Count = 1 Then
            EditToolStripMenuItem.Enabled = True
            HapusToolStripMenuItem.Enabled = True
            HapusToolStripMenuItem.Text = "Hapus ini"
        ElseIf ListView2.SelectedIndices.Count > 1 Then
            EditToolStripMenuItem.Enabled = False
            HapusToolStripMenuItem.Enabled = True
            HapusToolStripMenuItem.Text = "Hapus " + ListView2.SelectedIndices.Count.ToString + " Pendonor"
        Else
            HapusToolStripMenuItem.Enabled = False
            EditToolStripMenuItem.Enabled = False
        End If
    End Sub

    Private Sub HapusToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles HapusToolStripMenuItem.Click
        hapusPendonor()
    End Sub

    Private Sub EditToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles EditToolStripMenuItem.Click
        editPendonor()
    End Sub

    Public Sub editPendonor()
        Dim id = ListView2.FocusedItem.SubItems(1).Text
        Dim nama = ListView2.FocusedItem.SubItems(2).Text
        Dim alamat = ListView2.FocusedItem.SubItems(3).Text
        Dim goldar = ListView2.FocusedItem.SubItems(4).Text
        Dim ttl = ListView2.FocusedItem.SubItems(5).Text
        Dim tgl_lahir = (ttl.Substring(ttl.IndexOf(",") + 2))
        Dim tempat_lahir = ttl.Remove(ttl.IndexOf(","))
        Dim tinggi_badan = ListView2.FocusedItem.SubItems(7).Text
        Dim berat_badan = ListView2.FocusedItem.SubItems(8).Text
        Dim TambahEditPendonor1 As TambahEditPendonor = New TambahEditPendonor(Me, token, id, nama, alamat, goldar, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan)
        TambahEditPendonor1.ShowDialog()

    End Sub

    Private Sub RefreshToolStripMenuItem_Click(sender As Object, e As EventArgs) Handles RefreshToolStripMenuItem.Click
        loadData()
    End Sub

    Private Sub Button4_Click(sender As Object, e As EventArgs) Handles Button4.Click
        hapusPendonor()
    End Sub

    Private Sub ListView2_SelectedIndexChanged(sender As Object, e As EventArgs) Handles ListView2.SelectedIndexChanged
        If (ListView2.SelectedIndices.Count > 0) Then
            If Not Button4.Enabled Then
                Button4.Enabled = True
            End If
            ToolStripStatusLabel1.Text = ListView2.SelectedIndices.Count.ToString + " Pendonor dipilih"
        Else
            If Button4.Enabled Then
                ToolStripStatusLabel1.Text = ""
                Button4.Enabled = False
            End If
        End If
    End Sub
End Class