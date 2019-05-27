Imports System.IO
Imports System.Net
Imports System.Web.Script.Serialization

Public Class KoneksiMyBlood
    Dim status As HttpStatusCode = HttpStatusCode.ExpectationFailed

    Public Function PostResponse(url As String, content As String, ByRef statusCode As HttpStatusCode, token As String) As Byte()

        Dim responseFromServer As Byte() = Nothing
        Dim dataStream As Stream = Nothing

        Try
            Dim request As WebRequest = WebRequest.Create(url)
            request.Timeout = 120000
            request.Method = "POST"

            Dim byteArray As Byte() = System.Text.Encoding.UTF8.GetBytes(content)
            request.ContentType = "application/json"
            request.ContentLength = byteArray.Length
            request.Headers.Add("X-Authorization", "Bearer " + token)
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

    Public Function GetResponse(url As String, ByRef statusCode As HttpStatusCode, token As String) As String

        Dim webRequest = System.Net.HttpWebRequest.Create(url)

        webRequest.Method = "GET"
        webRequest.Headers.Add("X-Authorization", "Bearer " + token)

        Dim responseReader As StreamReader = New StreamReader(webRequest.GetResponse().GetResponseStream())
        Dim responseData As String = responseReader.ReadToEnd()

        responseReader.Close()
        webRequest.GetResponse().Close()
        Return responseData
    End Function
End Class
