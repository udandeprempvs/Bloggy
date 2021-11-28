<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>Document</title>
  </head>
  <body>
  <?php
    require('db.php');           //imports the db.php file
    // When form submitted, check and create user session.
    $id = $_GET['ID'];
    echo $id;
    $query    = "SELECT * FROM `blogs` WHERE blog_id='$id'";
    $result = mysqli_query($con, $query) or die(mysql_error());
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            $tags = $row['tags'];
            $title = $row['name'];
            $text = $row['body'];
        }
    }
    if (isset($_POST['add'])) {
        $title = stripslashes($_REQUEST['title']);    // removes backslashes
        //do with name 
        $title = mysqli_real_escape_string($con, $title);
        $tags = stripslashes($_REQUEST['tags']);
        $tags = mysqli_real_escape_string($con, $tags);
        // Check user is exist in the database
        $body = stripslashes($_REQUEST['myTextarea']);
        $body = mysqli_real_escape_string($con, $body);
        $email = $_SESSION['email'];
        $query    = "UPDATE `blogs` SET name='$title', body='$text' , tags = '$tags' WHERE blog_id='$id'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        if ($result) {
          header("Location:home.php");
      } else {
          echo "<div>
                <h3>Something went wrong.</h3><br/>
                </div>";
      }
    } 
    else { ?>
  <section>
      <nav class="back navbar navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"
            ><svg
              width="191"
              height="58"
              viewBox="0 0 191 58"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M43.1144 22H51.9344V48.352H53.9504V49H43.2584V48.352H45.2384V22.648H43.1144V22ZM72.397 41.908V38.848C72.397 36.52 72.265 34.828 72.001 33.772C71.761 32.692 71.185 32.152 70.273 32.152C69.745 32.152 69.313 32.308 68.977 32.62C68.665 32.908 68.437 33.4 68.293 34.096C68.077 35.176 67.969 36.82 67.969 39.028V41.836C67.969 44.452 68.041 46.024 68.185 46.552C68.353 47.08 68.521 47.512 68.689 47.848C68.953 48.424 69.469 48.712 70.237 48.712C71.173 48.712 71.785 48.172 72.073 47.092C72.289 46.324 72.397 44.596 72.397 41.908ZM70.165 49.36C67.165 49.36 64.897 48.592 63.361 47.056C61.825 45.52 61.057 43.324 61.057 40.468C61.057 37.588 61.873 35.38 63.505 33.844C65.161 32.284 67.477 31.504 70.453 31.504C73.429 31.504 75.649 32.224 77.113 33.664C78.577 35.08 79.309 37.252 79.309 40.18C79.309 46.3 76.261 49.36 70.165 49.36ZM100.872 29.992L101.88 29.38C102.024 28.636 101.736 28.264 101.016 28.264C99.9839 28.264 99.4679 29.056 99.4679 30.64C99.4679 31.264 99.5519 31.984 99.7199 32.8C101.544 34.024 102.456 35.596 102.456 37.516C102.456 39.412 101.796 40.888 100.476 41.944C99.1559 43 97.3679 43.528 95.1119 43.528C94.1759 43.528 93.2039 43.432 92.1959 43.24C91.1399 43.912 90.6119 44.416 90.6119 44.752C90.6119 45.088 91.3799 45.256 92.9159 45.256H96.5879C102.036 45.256 104.76 47.212 104.76 51.124C104.76 53.236 103.932 54.904 102.276 56.128C100.644 57.376 98.0879 58 94.6079 58C88.6799 58 85.7159 56.716 85.7159 54.148C85.7159 52.756 86.6399 51.796 88.4879 51.268L90.6479 52.24C90.4559 52.936 90.3599 53.596 90.3599 54.22C90.3599 56.284 91.8959 57.316 94.9679 57.316C96.8399 57.316 98.2799 56.968 99.2879 56.272C100.296 55.576 100.8 54.712 100.8 53.68C100.8 52.648 100.488 51.952 99.8639 51.592C99.2639 51.256 98.0519 51.088 96.2279 51.088H92.7359C90.7919 51.088 89.3999 50.764 88.5599 50.116C87.7199 49.468 87.2999 48.676 87.2999 47.74C87.2999 46.78 87.5999 45.988 88.1999 45.364C88.7999 44.716 89.8679 43.924 91.4039 42.988C88.6199 42.196 87.2279 40.372 87.2279 37.516C87.2279 35.716 87.8759 34.264 89.1719 33.16C90.4679 32.056 92.4119 31.504 95.0039 31.504C96.5639 31.504 97.8959 31.804 98.9999 32.404C98.8559 31.756 98.7839 31.168 98.7839 30.64C98.7839 29.296 99.1439 28.324 99.8639 27.724C100.584 27.124 101.388 26.824 102.276 26.824C103.164 26.824 103.872 27.064 104.4 27.544C104.952 28 105.228 28.636 105.228 29.452C105.228 30.268 105.012 30.88 104.58 31.288C104.148 31.672 103.62 31.864 102.996 31.864C102.396 31.864 101.892 31.708 101.484 31.396C101.1 31.06 100.896 30.592 100.872 29.992ZM93.2399 36.724V38.668C93.2399 40.276 93.3719 41.368 93.6359 41.944C93.9239 42.52 94.3439 42.808 94.8959 42.808C95.4719 42.808 95.8799 42.532 96.1199 41.98C96.3839 41.404 96.5159 40.24 96.5159 38.488V36.724C96.5159 34.852 96.3959 33.628 96.1559 33.052C95.9159 32.452 95.5079 32.152 94.9319 32.152C94.3799 32.152 93.9599 32.464 93.6719 33.088C93.3839 33.688 93.2399 34.9 93.2399 36.724ZM124.144 32.836C124.984 33.388 125.608 34 126.016 34.672C126.448 35.344 126.664 36.244 126.664 37.372C126.664 39.364 126.004 40.888 124.684 41.944C123.364 43 121.576 43.528 119.32 43.528C118.456 43.528 117.58 43.444 116.692 43.276C115.684 43.9 115.18 44.392 115.18 44.752C115.18 45.088 115.948 45.256 117.484 45.256H120.796C126.244 45.256 128.968 47.212 128.968 51.124C128.968 53.236 128.14 54.904 126.484 56.128C124.852 57.376 122.296 58 118.816 58C113.608 58 111.004 56.764 111.004 54.292C111.004 52.996 111.928 52.084 113.776 51.556L115.936 52.528C115.744 53.224 115.648 53.788 115.648 54.22C115.648 56.284 116.932 57.316 119.5 57.316C121.228 57.316 122.572 56.968 123.532 56.272C124.516 55.576 125.008 54.712 125.008 53.68C125.008 52.648 124.696 51.952 124.072 51.592C123.472 51.256 122.26 51.088 120.436 51.088H117.304C115.36 51.088 113.968 50.764 113.128 50.116C112.288 49.468 111.868 48.664 111.868 47.704C111.868 46.72 112.132 45.904 112.66 45.256C113.188 44.608 114.172 43.852 115.612 42.988C112.828 42.196 111.436 40.372 111.436 37.516C111.436 35.716 112.084 34.264 113.38 33.16C114.676 32.056 116.62 31.504 119.212 31.504C120.82 31.504 122.224 31.816 123.424 32.44C123.304 31.936 123.244 31.336 123.244 30.64C123.244 29.296 123.604 28.324 124.324 27.724C125.044 27.124 125.848 26.824 126.736 26.824C127.624 26.824 128.332 27.064 128.86 27.544C129.412 28 129.688 28.636 129.688 29.452C129.688 30.268 129.472 30.88 129.04 31.288C128.608 31.672 128.08 31.864 127.456 31.864C126.856 31.864 126.352 31.708 125.944 31.396C125.56 31.06 125.356 30.592 125.332 29.992L126.34 29.38C126.484 28.636 126.196 28.264 125.476 28.264C124.444 28.264 123.928 29.056 123.928 30.64C123.928 31.312 124 32.044 124.144 32.836ZM117.448 36.724V38.668C117.448 40.276 117.58 41.368 117.844 41.944C118.132 42.52 118.552 42.808 119.104 42.808C119.68 42.808 120.088 42.532 120.328 41.98C120.592 41.404 120.724 40.24 120.724 38.488V36.724C120.724 34.852 120.604 33.628 120.364 33.052C120.124 32.452 119.716 32.152 119.14 32.152C118.588 32.152 118.168 32.464 117.88 33.088C117.592 33.688 117.448 34.9 117.448 36.724ZM135.621 32.512V31.864H146.061V32.512H144.117L148.041 44.464L152.217 32.512H149.805V31.864H154.881V32.512H153.081L146.349 51.916C145.557 54.172 144.669 55.744 143.685 56.632C142.701 57.544 141.501 58 140.085 58C138.669 58 137.553 57.676 136.737 57.028C135.921 56.38 135.513 55.552 135.513 54.544C135.513 53.536 135.777 52.768 136.305 52.24C136.833 51.712 137.529 51.448 138.393 51.448C140.385 51.448 141.381 52.276 141.381 53.932C141.381 54.292 141.309 54.724 141.165 55.228H139.905C139.713 55.78 139.689 56.236 139.833 56.596C139.977 56.956 140.301 57.136 140.805 57.136C141.789 57.136 142.665 56.644 143.433 55.66C144.201 54.7 144.933 53.224 145.629 51.232L146.421 49H143.253L137.097 32.512H135.621Z"
                fill="white"
              />
              <path
                d="M9.1925 48.1691L29.6203 32L13.7888 28L10.7246 25L13.7888 22.5L31.6631 26.5L30.6417 7.5L12.7674 12L32.6845 0.5L36.77 7.5L38.3021 31L35.238 40L28.0882 42.5L9.1925 48.1691Z"
                fill="#FD633D"
              />
              <path
                d="M4.4941 48.1691H0V11L12.2567 2.5L4.4941 48.1691Z"
                fill="white"
              />
            </svg>
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span>
              <img
                src="../pic/icons8-sewing-button-50.png"
                alt=""
                height="40px"
              />
            </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">My Blogs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Starred Blogs</a>
              </li>
            </ul>
            <form class="d-flex">
              <input
                class="form-control mt-2 me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-outline-success mt-2 me-2" type="submit">
                Search
              </button>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="btn btn-outline-danger mt-2" href="./logout.php"
                  >Logout</a
                >
              </li>
            </ul>
          </div>
        </div>
      </nav>
    
      <div class="container">
        <form  method="post">
        <div class="form-outline mb-4">
          <label
            for="colFormLabelSm"
            class="col-sm-2 col-form-label text-white"
            >Title</label
          >
          <div class="col-sm-12">
            <input
            name="title"
              type="text"
              class="form-control border"
              placeholder="Enter Title"
              value = "<?php echo htmlentities($title); ?>"
            />
          </div>
        </div>
        <div class="form-outline mb-4">
          <label
            for="colFormLabelSm"
            class="col-sm-2 col-form-label text-white"
            >Tags</label
          >
          <div class="col-sm-12">
            <input
            name="tags"
              type="text"
              class="form-control border"
              placeholder="Enter Tags"
              value = "<?php echo htmlentities($tags); ?>"
            />
          </div>
      
          <label
          for="colFormLabelSm"
          class="col-sm-2 col-form-label text-white"
          >Body</label>
          <textarea name="myTextarea" id="myTextarea"></textarea>
      </div>
      <input
        type="submit"
        name="add"
        class="btn btn-primary btn-lg"
        style="padding-left: 2.5rem; padding-right: 2.5rem"
      />
      </form>
    </section>
    <?php } 
    
    ?>
  </body>
  <!-- JavaScript Bundle with Popper -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
  ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: "#myTextarea",
      height: "300px",
    });
  </script>
</html>
