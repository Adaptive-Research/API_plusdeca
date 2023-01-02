import requests

url = 'http://API.test:8011/API/Creer-Infos-Utilisateur'
url = 'http://PlusDeCA.api2/API/Creer-Infos-Utilisateur'

myobj = [ ('Submit' , '1') ,('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22') ,  ( 'Prenom' , 'test' ),  ( 'Nom' , 'test' ) ,( 'Email' , 'test@gmail.com' ), ( 'EmailVisible' , '1' ), ( 'Telephone' , '123456' ),  ( 'TelephoneVisible' , '1' ), ( 'Bio' , 'Hello' ), ( 'BioVisible' , '1' ) ]

x = requests.post(url, data = myobj)
print(x.text)

