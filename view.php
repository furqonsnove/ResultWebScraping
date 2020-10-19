<html>  
<head>  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <link rel="icon" href="dk.png">
  <title>EAI Web Scraping</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- <style type="text/css">
    .card-title{
      min-height: 100px;
    }
    .card-text {
      min-height: 120px;
    }
  </style> -->
</head>
<body>
  <!-- <nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand text-white" href="index.php">
      EAI WEB SCRAPING 
    </a>
  </nav> -->

  <div class="container">
      <h2 align="center">Price Comparasion "Laptop"</h2>
      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-6">
          <!--
          -- Input Group adalah salah satu komponen yang disediakan bootstrap
          -- Untuk lebih jelasnya soal Input Group, silahkan buka link ini : http://viid.me/qb4Mup
          -->
          <div class="input-group">
            <!-- Buat sebuah textbox dan beri id keyword -->
            <input type="text" class="form-control" placeholder="Pencarian..." id="keyword">
            
            <span class="input-group-btn">
              <!-- Buat sebuah tombol search dan beri id btn-search -->
              <button class="btn btn-primary" type="button" id="btn-search">SEARCH</button>
              <a href="" class="btn btn-warning">RESET</a>
            </span>
          </div>
        </div>
      </div>
      <br>
      

      <div class="row" id="load_data">
        <div class="row" id="load_data">
        <?php
            include 'koneksi.php';
        
            // $page = (isset($_GET['page']))? $_GET['page'] : 1;
            // $limit = 8; 
            // $limit_start = ($page - 1) * $limit;
            // $no = $limit_start + 1;

            $s_keyword="";
            if (isset($_POST['keyword'])) {
                $s_keyword = $_POST['keyword'];
                $page = (isset($_GET['page']))? $_GET['page'] : 1;
                $limit = 500; 
                $limit_start = ($page - 1) * $limit;
                $no = $limit_start + 1;
            }else{
              $page = (isset($_GET['page']))? $_GET['page'] : 1;
              $limit = 8; 
              $limit_start = ($page - 1) * $limit;
              $no = $limit_start + 1;
            }
            $search_keyword = '%'. $s_keyword .'%';
            $query = "SELECT * FROM products WHERE nama LIKE ? OR website LIKE ? ORDER BY id ASC LIMIT $limit_start, $limit";
            $dewan1 = $db1->prepare($query);
            $dewan1->bind_param('ss', $search_keyword, $search_keyword);
            $dewan1->execute();
            $res1 = $dewan1->get_result();
            if($res1->num_rows > 0){
              while ($row = $res1->fetch_assoc()) {
                $id = $row["id"];
                $nama = $row["nama"];
                $foto = $row["img_url"];
                $harga = $row["harga"];
                $web = $row["website"];
            
            
        ?>
            <div class="col-sm-3 mb-3">
            <div class="card border-primary mb-3">
                <img src="<?php echo $foto; ?>" class="card-img-top" alt="gambar">
                <div class="card-body text">
                <h5 class="card-title"><?php echo $nama; ?></h5>
                <p class="card-text"> Rp<?php echo number_format($harga); ?></p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?php echo $web; ?></small>
                </div>
            </div>
            </div>
        <?php 
        } 
        }else{
          echo "Tidak ada data ditemukan ";
        }
          ?>
          <br>
    
    </div>

      <?php
          

          
          $query_jumlah = "SELECT count(*) AS jumlah FROM products";
          $dewan1 = $db1->prepare($query_jumlah);
          $dewan1->execute();
          $res1 = $dewan1->get_result();
          $row = $res1->fetch_assoc();
          $total_records = $row['jumlah'];
        ?>
        <nav class="mt-1 mb-5">
          <ul class="pagination justify-content-center">
            <?php
              $jumlah_page = ceil($total_records / $limit);
              $jumlah_number = 4; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
              $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
              $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
              
              if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
              } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$link_prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
              }

              for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active' : '';
                echo '<li class="page-item '.$link_active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
              }

              if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
              } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item"><a class="page-link" href="?page='.$link_next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$jumlah_page.'">Last</a></li>';
              }
            
            ?>
          </ul>
        </nav>
  </div>

  <!-- <div class="text-center mt-5">© <?php echo date('Y'); ?> 
            Price Comparasion
  </div> -->
  
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>