<?= $this->response->type('application/json');
$this->response->charset('UTF-8');
$this->layout = 'ajax'; ?>
<?= json_encode($json, JSON_UNESCAPED_UNICODE); ?>