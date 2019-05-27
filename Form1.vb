Imports System
Imports System.IO
Imports System.Net
Imports System.Web.Script.Serialization

Public Class Form1
    Dim status As HttpStatusCode = HttpStatusCode.ExpectationFailed
    Dim url As String = Constants.url


    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        CheckIsi()
    End Sub

    Public Function PostResponse(url As String, content As String, ByRef statusCode As HttpStatusCode) As Byte()

        Dim responseFromServer As Byte() = Nothing
        Dim dataStream As Stream = Nothing

        Try
            Dim request As WebRequest = WebRequest.Create(url)
            request.Timeout = 120000
            request.Method = "POST"

            Dim byteArray As Byte() = System.Text.Encoding.UTF8.GetBytes(content)
            request.ContentType = "application/json"
            request.ContentLength = byteArray.Length
            dataStream = request.GetRequestStream()
            dataStream.Write(byteArray, 0, byteArray.Length)
            dataStream.Close()

            Dim response As WebResponse = request.GetResponse()
            dataStream = response.GetResponseStream()
            Dim ms As New MemoryStream()
            Dim thisRead As Integer = 0
            Dim buff As Byte() = New Byte(1023) {}
            Do
                thisRead = dataStream.Read(buff, 0, buff.Length)
                If thisRead = 0 Then
                    Exit Do
                End If
                ms.Write(buff, 0, thisRead)
            Loop While True
            responseFromServer = ms.ToArray()
            dataStream.Close()
            response.Close()
            statusCode = HttpStatusCode.OK

        Catch ex As WebException
            If ex.Response IsNot Nothing Then
                dataStream = ex.Response.GetResponseStream()
                Dim reader As New StreamReader(dataStream)
                Dim resp As String = reader.ReadToEnd()
                statusCode = DirectCast(ex.Response, HttpWebResponse).StatusCode
            Else
                Dim resp As String = ""

                statusCode = HttpStatusCode.ExpectationFailed

            End If

        Catch ex As Exception
            statusCode = HttpStatusCode.ExpectationFailed
        End Try
        Return responseFromServer

    End Function

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        If TextBox1.TextLength > 0 And TextBox2.TextLength > 0 Then
            ''MessageBox.Show("YES")
            Dim username As String
            Dim password As String
            username = TextBox1.Text
            password = TextBox2.Text
            Dim response As Byte() = PostResponse("http://" + url + "/volunteer/api/admin.php", "{""method"":""validate"", ""username"":""" + username + """,""password"":""" + password + """}", status)
            Dim responseString As String

            If response IsNot Nothing Then
                responseString = System.Text.Encoding.UTF8.GetString(response)
            Else
                responseString = "NULL"
            End If
            If Not responseString = "NULL" Then
                Dim jss As New JavaScriptSerializer()
                Dim dict As Dictionary(Of String, String) = jss.Deserialize(Of Dictionary(Of String, String))(responseString)
                Dim s As String
                s = dict("status")
                Dim token = "thistokenisfake"

                Try
                    token = dict("token")
                Catch ex As Exception
                    MessageBox.Show("No token received")
                End Try

                ''MessageBox.Show(dict("token"))

                ''MessageBox.Show("Response Code: " & status)
                ''Console.WriteLine("Response Code: " & status)
                ''MessageBox.Show("Response String: " & s)
                If s = "authenticated" Then
                    Dim AdminForm1 As AdminForm = New AdminForm(Me, token)
                    AdminForm1.Show()
                    ''Me.Hide()
                Else
                    MessageBox.Show("Username atau Password salah")
                End If
            Else
                MessageBox.Show("Koneksi bermasalah")
            End If
            ''Console.WriteLine("Response String: " & responseString)
        Else
            MessageBox.Show("NO")
        End If
    End Sub

    Private Sub PictureBox1_Click(sender As Object, e As EventArgs) Handles PictureBox1.Click

    End Sub

    Private Sub TextBox1_TextChanged(sender As Object, e As EventArgs) Handles TextBox1.TextChanged
        CheckIsi()
    End Sub


    Private Sub TextBox2_TextChanged(sender As Object, e As EventArgs) Handles TextBox2.TextChanged
        CheckIsi()
    End Sub

    Sub CheckIsi()
        If TextBox1.TextLength > 0 And TextBox2.TextLength > 0 Then
            Button1.Enabled = True
        Else
            Button1.Enabled = False
        End If
    End Sub

    Private Sub TextBox1_KeyDown(sender As Object, e As KeyEventArgs) Handles TextBox1.KeyDown
        If e.KeyCode = Keys.Enter Then
            ''MessageBox.Show("Enter")
        End If
    End Sub

    Private Sub TextBox2_KeyDown(sender As Object, e As KeyEventArgs) Handles TextBox2.KeyDown
        If e.KeyCode = Keys.Enter Then
            ''MessageBox.Show("Enter")
        End If
    End Sub

    Private Sub Label3_Click(sender As Object, e As EventArgs) Handles Label3.Click

    End Sub
End Class
