<?php
    move_uploaded_file($_FILES["file"]["tmp_name"], "../banner/" . $_FILES["file"]["name"]);