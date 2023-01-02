import requests

url = 'http://API.test:8011/API/Creer-Activite'
url = 'http://plusdeca.api2/API/Creer-Activite'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'idEntreprise' , '1' ) , ( 'Nom' , 'SEO' ) , ( 'Email' , 'contact@PlusVisible.fr' ),('Telephone','+33 6 98 86 38 94') ]

x = requests.post(url, data = myobj)
print(x.text)

