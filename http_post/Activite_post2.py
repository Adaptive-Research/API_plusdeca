import requests

url = 'http://API.test:8011/API/Modifier-Activite'
url = 'http://plusdeca.api2/API/Modifier-Activite'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'idActivite' , '1' ) , ( 'idEntreprise' , '1' ) , ( 'Nom' , 'test' ) , ( 'Description' , 'test2' ) , ( 'Email' , 'test' ),('Telephone','1234') ]

x = requests.post(url, data = myobj)
print(x.text)

