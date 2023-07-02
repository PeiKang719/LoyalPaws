<?php
include('Connection.php');

$state = $_GET['state'];

if ($state == 'Johor'){?>
    <option value="" disabled selected>Select shop area</option>
        <option>Batu Pahat</option>
        <option>Johor Bahru</option>
        <option>Kluang</option>
        <option>Kota Tinggi</option>
        <option>Kulai</option>
        <option>Mersing</option>
        <option>Muar</option>
        <option>Pontian</option>
        <option>Segamat</option>
        <option>Tangkak</option>
<?php 
} elseif($state=='Kedah') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Baling</option>
        <option>Bandar Baharu</option>
        <option>Kota Setar</option>
        <option>Kubang Pasu</option>
        <option>Kulim</option>
        <option>Langkawi</option>
        <option>Padang Terap</option>
        <option>Pendang</option>
        <option>Pokok Sena</option>
        <option>Sik</option>
        <option>Yan</option>

<?php 
} elseif($state=='Melaka') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Alor Gajah</option>
        <option>Bukit Katil</option>
        <option>Jasin</option>
        <option>Masjid Tanah</option>
        <option>Melaka Tengah</option>
        <option>Tangga Batu</option>
        

<?php 
} elseif($state=='Penang') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Barat Daya</option>
        <option>Seberang Perai Selatan</option>
        <option>Seberang Perai Tengah</option>
        <option>Seberang Perai Utara</option>
        <option>Timur Laut</option>

<?php 
} elseif($state=='Negeri Sembilan') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Jelebu</option>
        <option>Kuala Pilah</option>
        <option>Port Dickson</option>
        <option>Rembau</option>
        <option>Seremban</option>
        <option>Tampin</option>

<?php 
} elseif($state=='Kelantan') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Bachok</option>
        <option>Gua Musang</option>
        <option>Jeli</option>
        <option>Kota Bharu</option>
        <option>Kuala Krai</option>
        <option>Machang</option>
        <option>Pasir Mas</option>
        <option>Pasir Puteh</option>
        <option>Tanah Merah</option>
        <option>Tumpat</option>

<?php 
} elseif($state=='Terengganu') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Besut</option>
        <option>Dungun</option>
        <option>Hulu Terengganu</option>
        <option>Kemaman</option>
        <option>Kuala Nerus</option>
        <option>Kuala Terengganu</option>
        <option>Marang</option>
        <option>Setiu</option>

<?php 
} elseif($state=='Pahang') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Bera</option>
        <option>Bentong</option>
        <option>Cameron Highlands</option>
        <option>Jerantut</option>
        <option>Kuantan</option>
        <option>Lipis</option>
        <option>Maran</option>
        <option>Pekan</option>
        <option>Raub</option>
        <option>Rompin</option>
        <option>Temerloh</option>

<?php 
} elseif($state=='Selangor') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Gombak</option>
        <option>Hulu Langat</option>
        <option>Hulu Selangor</option>
        <option>Klang</option>
        <option>Kuala Langat</option>
        <option>Kuala Selangor</option>
        <option>Petaling</option>
        <option>Sabak Bernam</option>
        <option>Sepang</option>

<?php 
} elseif($state=='Sabah') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Beaufort</option>
        <option>Beluran</option>
        <option>Keningau</option>
        <option>Kinabatangan</option>
        <option>Kota Belud</option>
        <option>Kota Kinabalu</option>
        <option>Kota Marudu</option>
        <option>Kota Penyu</option>
        <option>Kudat</option>
        <option>Kunak</option>
        <option>Lahad Datu</option>
        <option>Nabawan</option>
        <option>Papar</option>
        <option>Penampang</option>
        <option>Pitas</option>
        <option>Putatan</option>
        <option>Ranau</option>
        <option>Sandakan</option>
        <option>Semporna</option>
        <option>Sipitang</option>
        <option>Tambunan</option>
        <option>Tawau</option>
        <option>Tenom</option>
        <option>Tongod</option>
        <option>Tuaran</option>

<?php 
} elseif($state=='Sarawak') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Betong</option>
        <option>Bintulu</option>
        <option>Kapit</option>
        <option>Kuching</option>
        <option>Limbang</option>
        <option>Miri</option>
        <option>Mukah</option>
        <option>Samarahan</option>
        <option>Sarikei</option>
        <option>Serian</option>
        <option>Sibu</option>
        <option>Sri Aman</option>

<?php 
} elseif($state=='Kuala Lumpur') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Batu</option>
        <option>Bukit Bintang</option>
        <option>Cheras</option>
        <option>Kepong</option>
        <option>Lembah Pantai</option>
        <option>Segambut</option>
        <option>Setiawangsa</option>
        <option>Titiwangsa</option>
        <option>Wangsa Maju</option>

<?php 
} elseif($state=='Perak') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Batang Padang</option>
        <option>Hilir Perak</option>
        <option>Hulu Perak</option>
        <option>Kampar</option>
        <option>Kerian</option>
        <option>Kinta</option>
        <option>Kuala Kangsar</option>
        <option>Larut&Matang</option>
        <option>Manjung</option>
        <option>Muallim</option>
        <option>Perak Tengah</option>

<?php 
} elseif($state=='Perlis') { ?>
    <option value="" disabled selected>Select shop area</option>
        <option>Arau</option>
        <option>Kaki Bukit</option>
        <option>Kangar</option>
        <option>Kuala Perlis</option>
        <option>Padang Besar</option>
        <option>Simpang Ampat</option>

<?php 
} elseif($state=='Labuan') { ?>
        <option>Labuan</option>


<?php 
} elseif($state=='Putrajaya') { ?>
        <option>Putrajaya</option>


<?php
}

$conn->close();
?>
