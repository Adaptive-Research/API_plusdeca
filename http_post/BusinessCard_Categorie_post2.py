import requests

url = 'http://API.test:8011/API/Modifier-Categorie-BusinessCard'



myobj = [ ('Submit' , '1'),  ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'id' , '2' ) , ('Categorie',"test"), ('Ordre','2')  ]

x = requests.post(url, data = myobj)
print(x.text)

