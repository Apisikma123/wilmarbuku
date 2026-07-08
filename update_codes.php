<?php
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
DB::update("UPDATE transaksi_checkout SET kode_tracking = REPLACE(kode_tracking, 'WLH-', 'WB-') WHERE kode_tracking LIKE 'WLH-%'");
DB::update("UPDATE transaksi_detail SET kode_tracking = REPLACE(kode_tracking, 'WLH-', 'WB-') WHERE kode_tracking LIKE 'WLH-%'");
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "Updated successfully.\n";
