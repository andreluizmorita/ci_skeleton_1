<?php

$config['qrcode_data_path']	 = 'qr_code/data';
$config['qrcode_image_path'] = 'qr_code/image';
$config['qrcode_save_path']  = 'qr_code/';

$config['qrcode_default_f']	 = 'qr_code';
$config['qrcode_default_e']	 = 'M';
$config['qrcode_default_s']	 = '6';
$config['qrcode_default_v']	 = 'auto';
$config['qrcode_default_ext']	 = '.jpeg';

/* The variables represented above are:

	d = URL encoded data - whatever you want to encode into the image.
	e = ECC level: L, M, Q, H (default M)
	s = module size: 4-16 (default PNG:4, JPEG:8)
	v = version: 1-40 or Auto (default: Auto)
	t = image type: J = jpeg image, P = PNG image

*/