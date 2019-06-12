<div style="font-size: 14px; color: #000">
	<h1 style="font-size: 16px; text-align: center;">Расписка в получении денежных средств</h1>
	<p style="text-align: left; padding-top: 40px;"><?= \App\Lib\Misc::mb_ucfirst(\App\Lib\Misc::getCurrentDateString(), 'utf-8') ?><br />г. Москва</p>
	<p style="text-align: justify; padding-top: 40px;">
		Я, <?= $courier->lastname . ' ' . $courier->firstname . ' ' . $courier->VtigerContactscf->cf_930 . ', ' . (empty($courier->VtigerContactsubdetails->birthday) ? '' : $courier->VtigerContactsubdetails->birthday->format('Y')) . ' года рождения, место рождения: ' . $courier->VtigerContactscf->cf_931 ?>, имеющий(ая) паспорт серии <?= $courier->VtigerContactscf->cf_932 ?> номер <?= $courier->VtigerContactscf->cf_933 ?>, выданный <?= $courier->VtigerContactscf->cf_934 ?>
		код подразделения <?= $courier->VtigerContactscf->cf_935 ?>, зарегистрированный по адресу <?= $courier->VtigerContactscf->cf_936 ?>, получил(а) от Кудинова Артема Олеговича, 23 марта 1989 г.р., родившегося в г. Красноярск-66, имеющего паспорт серии 4510 номер 114042, выданный  13.04.2009 отделением по р-ну Хорошево-Мневники ОУФМС России по г. Москве в СЗАО, код подразделения 770-097, зарегистрированного по адресу г. Москва, ул. Маршала Тухачевского 16/2, кв.128
		наличные денежные средства в размере <?= ceil($total) ?> рублей 00 копеек.</p>
	<p style="text-align: justify">
		Деньги обязуюсь вернуть не позднее 00:00 часов <?= date('d.m.Y', strtotime('tomorrow'))?> года.
	</p>
	<p style="text-align: right;padding-top: 120px;"> ____________________ / __________________</p>
</div>

