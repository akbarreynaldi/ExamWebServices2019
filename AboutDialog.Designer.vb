﻿<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class AboutDialog
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(AboutDialog))
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox()
        Me.Button1 = New System.Windows.Forms.Button()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'PictureBox1
        '
        Me.PictureBox1.BackgroundImage = Global.MyBlood.My.Resources.Resources.logo
        Me.PictureBox1.BackgroundImageLayout = System.Windows.Forms.ImageLayout.None
        Me.PictureBox1.Location = New System.Drawing.Point(90, 29)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(153, 158)
        Me.PictureBox1.TabIndex = 0
        Me.PictureBox1.TabStop = False
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Roboto", 20.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.ForeColor = System.Drawing.Color.Maroon
        Me.Label1.Location = New System.Drawing.Point(103, 190)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(122, 33)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "Volunteer"
        '
        'RichTextBox1
        '
        Me.RichTextBox1.BackColor = System.Drawing.SystemColors.ControlLightLight
        Me.RichTextBox1.BorderStyle = System.Windows.Forms.BorderStyle.None
        Me.RichTextBox1.Location = New System.Drawing.Point(31, 238)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.Size = New System.Drawing.Size(274, 150)
        Me.RichTextBox1.TabIndex = 2
        Me.RichTextBox1.Text = "Dibuat Mei 2018" & Global.Microsoft.VisualBasic.ChrW(10) & Global.Microsoft.VisualBasic.ChrW(10) & "- Ajeng Shaffira Atthariq" & Global.Microsoft.VisualBasic.ChrW(10) & "- Ardiansah" & Global.Microsoft.VisualBasic.ChrW(10) & "- Ejah Said Mansur" & Global.Microsoft.VisualBasic.ChrW(10) & "- Ihsan" &
    " Hasanudin" & Global.Microsoft.VisualBasic.ChrW(10) & "- Ulfah Nuraeni" & Global.Microsoft.VisualBasic.ChrW(10) & Global.Microsoft.VisualBasic.ChrW(10) & "API URL: http://192.168.100.156/volunteer" &
    "/api"
        '
        'Button1
        '
        Me.Button1.DialogResult = System.Windows.Forms.DialogResult.Cancel
        Me.Button1.Location = New System.Drawing.Point(126, 394)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 23)
        Me.Button1.TabIndex = 3
        Me.Button1.Text = "OK"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'AboutDialog
        '
        Me.AcceptButton = Me.Button1
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.CancelButton = Me.Button1
        Me.ClientSize = New System.Drawing.Size(327, 440)
        Me.ControlBox = False
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.RichTextBox1)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.PictureBox1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.Name = "AboutDialog"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
        Me.Text = "About"
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents PictureBox1 As PictureBox
    Friend WithEvents Label1 As Label
    Friend WithEvents RichTextBox1 As RichTextBox
    Friend WithEvents Button1 As Button
End Class
