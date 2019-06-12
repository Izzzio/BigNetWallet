<?= $this->response->type('application/x-javascript');
$this->response->charset('UTF-8');
$this->layout = 'ajax'; ?>
<?= preg_replace('/[^0-9a-z\-\$\.\_]/i', '', isset($_GET['callback'])? $_GET['callback']: 'callback').'('.json_encode($json).');'; ?>