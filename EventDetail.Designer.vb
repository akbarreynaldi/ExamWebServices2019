<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class EventDetail
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
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(EventDetail))
        Me.namaEvent = New System.Windows.Forms.Label()
        Me.waktuEvent = New System.Windows.Forms.Label()
        Me.tempatEvent = New System.Windows.Forms.Label()
        Me.partisipanLabel = New System.Windows.Forms.Label()
        Me.ListView1 = New System.Windows.Forms.ListView()
        Me.deskripsiEvent = New System.Windows.Forms.Label()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.PictureBox2 = New System.Windows.Forms.PictureBox()
        Me.PictureBox3 = New System.Windows.Forms.PictureBox()
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'namaEvent
        '
        Me.namaEvent.AutoSize = True
        Me.namaEvent.Font = New System.Drawing.Font("Myriad Pro", 18.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.namaEvent.Location = New System.Drawing.Point(20, 23)
        Me.namaEvent.Name = "namaEvent"
        Me.namaEvent.Size = New System.Drawing.Size(136, 30)
        Me.namaEvent.TabIndex = 1
        Me.namaEvent.Text = "namaEvent"
        '
        'waktuEvent
        '
        Me.waktuEvent.AutoSize = True
        Me.waktuEvent.Font = New System.Drawing.Font("Segoe UI", 11.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.waktuEvent.Location = New System.Drawing.Point(49, 325)
        Me.waktuEvent.Name = "waktuEvent"
        Me.waktuEvent.Size = New System.Drawing.Size(53, 20)
        Me.waktuEvent.TabIndex = 1
        Me.waktuEvent.Text = "Label1"
        '
        'tempatEvent
        '
        Me.tempatEvent.AutoSize = True
        Me.tempatEvent.Font = New System.Drawing.Font("Segoe UI", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.tempatEvent.Location = New System.Drawing.Point(50, 351)
        Me.tempatEvent.Name = "tempatEvent"
        Me.tempatEvent.Size = New System.Drawing.Size(46, 17)
        Me.tempatEvent.TabIndex = 1
        Me.tempatEvent.Text = "Label1"
        '
        'partisipanLabel
        '
        Me.partisipanLabel.AutoSize = True
        Me.partisipanLabel.Location = New System.Drawing.Point(300, 61)
        Me.partisipanLabel.Name = "partisipanLabel"
        Me.partisipanLabel.Size = New System.Drawing.Size(53, 13)
        Me.partisipanLabel.TabIndex = 2
        Me.partisipanLabel.Text = "Partisipan"
        '
        'ListView1
        '
        Me.ListView1.Location = New System.Drawing.Point(303, 77)
        Me.ListView1.Name = "ListView1"
        Me.ListView1.Size = New System.Drawing.Size(569, 329)
        Me.ListView1.TabIndex = 3
        Me.ListView1.UseCompatibleStateImageBehavior = False
        '
        'deskripsiEvent
        '
        Me.deskripsiEvent.Location = New System.Drawing.Point(22, 371)
        Me.deskripsiEvent.Name = "deskripsiEvent"
        Me.deskripsiEvent.Size = New System.Drawing.Size(254, 49)
        Me.deskripsiEvent.TabIndex = 1
        Me.deskripsiEvent.Text = "Label1"
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(797, 422)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(75, 23)
        Me.Button2.TabIndex = 5
        Me.Button2.Text = "Close"
        Me.Button2.UseVisualStyleBackColor = True
        '
        'PictureBox2
        '
        Me.PictureBox2.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center
        Me.PictureBox2.Image = Global.MyBlood.My.Resources.Resources.tanggal
        Me.PictureBox2.Location = New System.Drawing.Point(25, 324)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(18, 20)
        Me.PictureBox2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox2.TabIndex = 6
        Me.PictureBox2.TabStop = False
        '
        'PictureBox3
        '
        Me.PictureBox3.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center
        Me.PictureBox3.Image = Global.MyBlood.My.Resources.Resources.location
        Me.PictureBox3.Location = New System.Drawing.Point(25, 348)
        Me.PictureBox3.Name = "PictureBox3"
        Me.PictureBox3.Size = New System.Drawing.Size(18, 20)
        Me.PictureBox3.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox3.TabIndex = 6
        Me.PictureBox3.TabStop = False
        '
        'PictureBox1
        '
        Me.PictureBox1.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Center
        Me.PictureBox1.Location = New System.Drawing.Point(25, 61)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(251, 247)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom
        Me.PictureBox1.TabIndex = 0
        Me.PictureBox1.TabStop = False
        '
        'EventDetail
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(897, 457)
        Me.Controls.Add(Me.PictureBox2)
        Me.Controls.Add(Me.PictureBox3)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.ListView1)
        Me.Controls.Add(Me.partisipanLabel)
        Me.Controls.Add(Me.deskripsiEvent)
        Me.Controls.Add(Me.tempatEvent)
        Me.Controls.Add(Me.waktuEvent)
        Me.Controls.Add(Me.namaEvent)
        Me.Controls.Add(Me.PictureBox1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle
        Me.Icon = CType(resources.GetObject("$this.Icon"), System.Drawing.Icon)
        Me.MaximizeBox = False
        Me.Name = "EventDetail"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
        Me.Text = "EventDetail"
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox3, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents PictureBox1 As PictureBox
    Friend WithEvents namaEvent As Label
    Friend WithEvents waktuEvent As Label
    Friend WithEvents tempatEvent As Label
    Friend WithEvents partisipanLabel As Label
    Friend WithEvents ListView1 As ListView
    Friend WithEvents deskripsiEvent As Label
    Friend WithEvents Button2 As Button
    Friend WithEvents PictureBox3 As PictureBox
    Friend WithEvents PictureBox2 As PictureBox
End Class
