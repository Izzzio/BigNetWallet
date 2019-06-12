<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<style>
			/*
			url(<?= WWW_ROOT; ?>fonts/arialli.ttf);
			url(<?= WWW_ROOT; ?>fonts/arialbi.ttf);
			url(<?= WWW_ROOT; ?>fonts/ARIALN.ttf),
			url(<?= WWW_ROOT; ?>fonts/ARIALNB.ttf),
			url(<?= WWW_ROOT; ?>fonts/ARIALNBI.ttf),
			url(<?= WWW_ROOT; ?>fonts/ARIALNI.ttf),
			url(<?= WWW_ROOT; ?>fonts/ariblk.ttf);*/

			/*для pdf*/
			@font-face {
				font-family: 'arial-1';
				font-style: normal;
				src:  url(<?= WWW_ROOT; ?>fonts/arial.ttf);
			}
			@font-face {
				font-family: 'arial-1';
				font-weight: bold;
				font-style: normal;
				src: url(<?= WWW_ROOT; ?>fonts/arialbd.ttf);
			}


			/*для тестов*/
			@font-face {
				font-family: 'arial-2';
				font-style: normal;
				src:  url(<?= URL_PREFIX; ?>/fonts/arial.ttf);
			}
			@font-face {
				font-family: 'arial-2';
				font-weight: bold;
				font-style: normal;
				src: url(<?= URL_PREFIX; ?>/fonts/arialbd.ttf);
			}

			body {
				font-family: 'arial-1', 'arial-2';
				/*font-weight: bold;*/
			}

			/*h1 {font-family: 'arial-1', 'arial-2', sans-serif; font-weight: bold;}
			h2 {font-family: 'arial-1', 'arial-2', sans-serif; font-weight: bold;}
			th {font-family: 'arial-1', 'arial-2', sans-serif; font-weight: bold;}
			td {font-family: 'arial-1', 'arial-2', sans-serif; font-weight: normal;}*/

		</style>
	</head>
	<body>
		<?= $this->fetch('content') ?>
	</body>
</html>