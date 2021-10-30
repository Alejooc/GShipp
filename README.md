# GShipp

# Install 
- Copiar el archivo Shippment.php y pegar en la carpeta libraries (ya existente en codeigniter)
- importar la libreria  $this->load->library('shippment')
- parametros: Envia = server->env,guia->xxxxxxxxxx  Servientrega = server->serv,guia->xxxxxxxxxx
- para hacer uso del metodo main debe ingresar los parametros con el siguiente formato  ['server'=>'env','guia'=> '024018980913']
- Metodo main uso: $this->shippment->main(['server'=>'env','guia'=> '024018980913']) Retorna Objeto
- Codigo ejemplo:  $data = $this->shippment->main(['server'=>'env','guia'=> '024018980913']); var_dump($data); 
