<?php
// menambahkan data json sebagai penyimpan data yg masuk di $berkas
$berkas = "data2/data.json";

// mengambil data dari filejson
$dataJson = file_get_contents($berkas);

// mengkonversi data json menjadi sintak php
$dataPendaftaranBrand = json_decode($dataJson, true);

$brand = ["NIKE", "ADIDAS", "CONFERSE", "BATA"];
$seller = ["ASIA", "EROPA","AUSTRALIA","AFRIKA"];
$pajakBrand = ["NIKE"=> 50000, "ADIDAS"=> 30000, "CONFERSE" =>40000, "BATA" => 40000];
$pajakSeller   = ["ASIA" => 80000, "EROPA" => 70000, "AUSTRALIA" => 90000, "AFRIKA" =>70000];

function total_pajak($pajakBrandawal, $pajakSellerawal){
    global $pajakBrand, $pajakSeller;
    foreach($pajakBrand as $pjkA => $pjkA_value){
        if($pajakBrandawal == $pjkA){
            $pajak1 = $pjkA_value;
        }
    }

    foreach($pajakSeller as $pjkB => $pjkB_value){
        if($pajakSellerawal == $pjkB){
            $pajak2 = $pjkB_value;
        }
    }

    return $pajak1 + $pajak2;
}


// menghitung total harga
function total_harga($totalPajak, $hargaTiket){
    $totalHarga = $totalPajak + $hargaTiket;
    return $totalHarga;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS2/style.css">
    <!-- botsrap 5 link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Daftar Sell Shop</title>
</head>
<body>
<div class="card p-5" style="width:550px; margin:50px auto;" id="card">
    <div class="d-flex justify-content-center">
        <img src="assets/img/brandsport.png" alt="" style="width:200px">
    </div>
    <form action="daftartoko.php" method="POST">
       <h2 class="text-center">PENDAFTARAN JUAL SEPATU</h2>

       <div class="d-flex mb-3 justify-content-between">
           <label for="">Nama Toko</label>
           <input type="text" name="namatk" class="form-control" style="width:45%">
       </div>

       <div class="d-flex mb-3  justify-content-between">
           <label for="">Brand Sepatu</label>
           <select name="brand" id="" class="form-select " style="width:45%">
               <option value="">--Pilih Brand Sepatu--</option>
               <?php
                   foreach($brand as $brd){
                      echo" <option value='".$brd."'>".$brd."</option>";
                   }
               ?>
           </select>
       </div>
       <div class="d-flex mb-3  justify-content-between">
           <label for="">Seller Sepatu</label>
           <select name="seller" id=""  class="form-select" style="width:45%">
               <option value="">--Pilih Seller Sepatu--</option>
               <?php
                   foreach($seller as $sell){
                      echo" <option value='".$sell."'>".$sell."</option>";
                   }
               ?>
           </select>
       </div>

       <div class="d-flex justify-content-between mb-3">
           <label >Harga Seller</label>
           <input type="text" name="harga" class="form-control" style="width:45%">
       </div>

       <div class="tombol d-flex justify-content-center ">
           <input type="submit"  name="daftar" value="Daftar" id="daftar" class="p-2">
       </div>

    </form>
</div>

<?php
   if(isset($_POST['daftar'])){
       $namatk = $_POST['namatk'];
       $namaBrand = $_POST['brand'];
       $namaSeller = $_POST['seller'];
       $hargaTiket = $_POST['harga'];
        
       $totalPajak = total_pajak($namaBrand, $namaSeller);
       $totalHarga = total_harga($totalPajak, $hargaTiket);


       $dataPendaftaran = [$namatk,$namaBrand,$namaSeller,$hargaTiket,$totalPajak,$totalHarga];
       array_push($dataPendaftaranBrand, $dataPendaftaran);
       array_multisort($dataPendaftaranBrand, SORT_ASC);
       $dataJson = json_encode($dataPendaftaranBrand, JSON_PRETTY_PRINT);
       file_put_contents($berkas,$dataJson);

   }
?>

<!-- Menampilkan data dalam bentuk tabel -->
<h2 class="text-center">Data Pendaftaran Product Sepatu</h2>
<div class="d-flex justify-content-center">
<table border="1" width="800px">
    <thead>
       <tr class="bg-warning">
           <th class="text-center">Nama Toko</th>
           <th class="text-center">Nama Brand</th>
           <th class="text-center">Brand</th>
           <th class="text-center">Harga Seller</th>
           <th class="text-center">Total Pajak</th>
           <th class="text-center">Total Harga</th>
       </tr>  
    </thead>

    <tbody>
        <?php
           for($i=0; $i < count($dataPendaftaranBrand); $i++){
              echo" <tr>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][0]."</td>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][1]."</td>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][2]."</td>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][3]."</td>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][4]."</td>";
              echo" <td class='text-center'>".$dataPendaftaranBrand[$i][5]."</td>";
              echo" </tr>";
                
           }
        ?>
    </tbody>


</table>

</div>


    
</body>
</html>