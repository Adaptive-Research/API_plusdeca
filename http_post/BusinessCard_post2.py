import requests

url = 'http://API.test:8011/API/Modifier-BusinessCard'



myobj = [ ('Submit' , '1'),  ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'id' , '1' ) , ('LieuRencontre',"Salon d'ete"), ( 'Entreprise' , 'test2' ) , ( 'SiteWeb' , 'www.test2.eu' ), ( 'Sexe' , 'homme' ), ( 'Prenom' , 'Dominique' ),( 'Nom' , 'Dupard' ), ( 'Fonction' , 'CTO' ), ( 'Email' , 'contact@test2.eu' ),('Telephone','12345')  ]

x = requests.post(url, data = myobj)
print(x.text)

