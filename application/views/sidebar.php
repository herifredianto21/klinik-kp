			<div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li id="li-dashboard">
            <a href="<?php echo base_url('dashboard/'); ?>">
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
            </a>
			    </li>
					<li id="li-antrian">
            <a href="<?php echo base_url('antrian/'); ?>">
              <i class="fas fa-address-book"></i>
              <p>Kunjungan</p>
            </a>
					</li>
					<li id="li-tindakan-medis">
            <a href="<?php echo base_url('tindakan-medis/'); ?>">
              <i class="fas fa-notes-medical"></i>
              <p>Tindakan Medis</p>
            </a>
					</li>
					<li id="li-apotek">
            <a href="<?php echo base_url('apotek/'); ?>">
              <i class="fas fa-clinic-medical"></i>
              <p>Apotek</p>
            </a>
					</li>
					<li id="li-pasien">
            <a href="<?php echo base_url('pasien/'); ?>">
              <i class="fas fa-procedures"></i>
              <p>Pasien</p>
            </a>
					</li>
					<li id="li-rekam-medis">
            <a href="<?php echo base_url('rekam-medis/'); ?>">
              <i class="fas fa-file-medical-alt"></i>
              <p>Rekam Medis</p>
            </a>
					</li>
					<li id="li-laporan">
            <a href="<?php echo base_url('laporanRm/'); ?>">
              <i class="fas fa-file-medical"></i>
              <p>Laporan Rekam Medis</p>
            </a>
					</li>
					<li id="li-histori-tindakan-medis">
            <a href="<?php echo base_url('histori-tindakan-medis/'); ?>">
              <i class="fas fa-file-medical"></i>
              <p>Histori Tindakan Medis</p>
            </a>
					</li>
					<li id="li-obat">
            <a href="<?php echo base_url('obat/'); ?>">
              <i class="fas fa-pills"></i>
              <p>Obat</p>
            </a>
					</li>
					<li id="li-pembelian">
            <a href="<?php echo base_url('pembelian/'); ?>">
              <i class="fas fa-cart-arrow-down"></i>
              <p>Pembelian</p>
            </a>
					</li>
					<!-- <li id="li-pembayaran">
            <a href="<?php echo base_url('pembayaran/'); ?>">
              <i class="fas fa-money-bill-wave"></i>
              <p>Pembayaran</p>
            </a>
					</li>
					<li id="li-penjualan">
            <a href="<?php echo base_url('penjualan/'); ?>">
              <i class="fas fa-store"></i>
              <p>Penjualan</p>
            </a>
					</li> -->
					<li id="li-supplier">
            <a href="<?php echo base_url('supplier/'); ?>">
              <i class="fas fa-store-alt"></i>
              <p>Supplier</p>
            </a>
					</li>
					<li>
						<a data-toggle="collapse" href="#menuSurat" >
							<i class="fas fa-envelope"></i>
							<p>
								Surat <b class="caret"></b>
							</p>
						</a>
						<div class="collapse " id="menuSurat">
							<ul class="nav">
								<li id="li-surat-sakit">
									<a href="<?php echo base_url('surat-sakit/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Sakit</p>
									</a>
								</li>
								<li id="li-surat-lahir">
									<a href="<?php echo base_url('surat-lahir/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Keterangan Lahir</p>
									</a>
								</li>
								<li id="li-surat-postpartum">
									<a href="<?php echo base_url('surat-postpartum/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Keterangan Kontrol</p>
									</a>
								</li>
								<li id="li-surat-hamil">
									<a href="<?php echo base_url('surat-hamil/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Hamil</p>
									</a>
								</li>
								<li id="li-surat-keterangan-hamil">
									<a href="<?php echo base_url('surat-keterangan-hamil/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Keterangan Hamil</p>
									</a>
								</li>
								<li id="li-surat-rujukan">
                  <a href="<?php echo base_url('surat-rujukan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Surat Rujukan</p>
									</a>
								</li>
							</ul>
							<hr>
						</div>
					</li>
					<!-- <li>
						<a data-toggle="collapse" href="#menuLaporan" >
							<i class="now-ui-icons files_single-copy-04"></i>
							<p>
								Laporan <b class="caret"></b>
							</p>
						</a>
						<div class="collapse " id="menuLaporan">
							<ul class="nav">
								<li id="li-laporat-akseptor-kb">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Akseptor KB</p>
									</a>
								</li>
								<li id="li-laporan-partus">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Partus</p>
									</a>
								</li>
								<li id="li-laporan-pemeriksaan">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Pemeriksaan</p>
									</a>
								</li>
								<li id="li-laporan-imunisasi">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Imunisasi</p>
									</a>
								</li>
								<li id="li-laporan-stock">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Stock</p>
									</a>
								</li>
								<li id="li-laporan-keuangan">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Keuangan</p>
									</a>
								</li>
								<li id="li-laporan-bulanan">
									<a href="">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Laporan Bulanan</p>
									</a>
								</li>
							</ul>
							<hr>
						</div>
					</li> -->
					<li>
						<a data-toggle="collapse" href="#menuMaster" >
							<i class="fas fa-box"></i>
							<p>
								Master <b class="caret"></b>
							</p>
						</a>
						<div class="collapse " id="menuMaster">
							<ul class="nav">
                <li id="li-penyakit">
									<a href="<?php echo base_url('penyakit/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Penyakit</p>
									</a>
								</li>
								<li id="li-asuransi">
									<a href="<?php echo base_url('asuransi/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Asuransi</p>
									</a>
								</li>
								<li id="li-kelas-asuransi">
									<a href="<?php echo base_url('kelas-asuransi/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Kelas Asuransi</p>
									</a>
								</li>
								<li id="li-biaya-medis">
									<a href="<?php echo base_url('biaya-medis/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Tindakan & Biaya Medis</p>
									</a>
								</li>
								<li id="li-data-icd">
									<a href="<?php echo base_url('data-icd/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Data ICD</p>
									</a>
								</li>
								<li id="li-desa">
									<a href="<?php echo base_url('desa/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Desa</p>
									</a>
								</li>
								<li id="li-dokter">
									<a href="<?php echo base_url('dokter/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Dokter</p>
									</a>
								</li>
								<li id="li-karyawan">
									<a href="<?php echo base_url('karyawan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Karyawan</p>
									</a>
								</li>
								<li id="li-hari-praktek">
									<a href="<?php echo base_url('hari-praktek/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Hari Praktek</p>
									</a>
								</li>
								<li id="li-jenis-pelayanan">
									<a href="<?php echo base_url('jenis-pelayanan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Jenis Pelayanan</p>
									</a>
								</li>
								<li id="li-kota">
									<a href="<?php echo base_url('kota/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Kota</p>
									</a>
								</li>
								<li id="li-kategori">
									<a href="<?php echo base_url('kategori/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Kategori</p>
									</a>
								</li>
								<li id="li-obat">
									<a href="<?php echo base_url('obat/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Obat</p>
									</a>
								</li>
								<li id="li-pekerjaan">
									<a href="<?php echo base_url('pekerjaan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Pekerjaan</p>
									</a>
								</li>
								<li id="li-satuan">
									<a href="<?php echo base_url('satuan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Satuan</p>
									</a>
								</li>
							</ul>
							<hr>
						</div>
					</li>
					<li>
						<a data-toggle="collapse" href="#menuTim" >
							<i class="fas fa-user-friends"></i>
							<p>
								Tim <b class="caret"></b>
							</p>
						</a>
						<div class="collapse " id="menuTim">
							<ul class="nav">
								<li id="li-user">
									<a href="<?php echo base_url('user/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>User</p>
									</a>
								</li>
								<li id="li-department">
									<a href="<?php echo base_url('department/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Department</p>
									</a>
								</li>
								<li id="li-karyawan">
									<a href="<?php echo base_url('karyawan/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Karyawan</p>
									</a>
								</li>
								<li id="li-role">
									<a href="<?php echo base_url('role/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Role</p>
									</a>
								</li>
								<li id="li-permission">
									<a href="<?php echo base_url('permission/'); ?>">
										<i class="now-ui-icons arrows-1_minimal-right"></i>
										<p>Permission</p>
									</a>
								</li>
							</ul>
							<hr>
						</div>
					</li>
					<li id="li-logout">
            <a href="<?php echo base_url('dashboard/logout/'); ?>">
              <i class="fas fa-power-off"></i>
              <p>Logout</p>
            </a>
					</li>
        </ul>
      </div>
