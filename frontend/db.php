<?php
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    
    $con = mysqli_connect("localhost","root","");
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    //creating the db by itself
    $sql = "CREATE DATABASE IF NOT EXISTS bloggy";
    if(mysqli_query($con, $sql)){
        $con = mysqli_connect("localhost", "root", "", "bloggy");
        //sql schema
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT ,
            fname varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            pass varchar(50) NOT NULL,
            PRIMARY KEY(id)
           );
           ";
        
        if(!mysqli_query($con, $sql)){
            echo "Cannot Create table...!";
        }

    }else{
        echo "Error while creating database ". mysqli_error($con);
    }


    if(mysqli_query($con, $sql)){
        $con = mysqli_connect("localhost", "root", "", "bloggy");

        $sql = "
        CREATE TABLE IF NOT EXISTS blogs(
            blog_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR (25) NOT NULL,
            body VARCHAR (1125) NOT NULL,
            tags VARCHAR (125) NOT NULL,
            user_email VARCHAR (20)
        );
           ";
        
        if(!mysqli_query($con, $sql))
        {
            echo "Cannot Create table...!";
        }

    }else{
        echo "Error while creating database ". mysqli_error($con);
    }

?> 
