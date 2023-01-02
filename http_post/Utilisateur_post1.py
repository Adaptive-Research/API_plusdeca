import requests

#url = 'http://API.test:8011/API/Creer-Compte-Utilisateur'
url = 'http://plusdeca.api2/API/Creer-Compte-Utilisateur'


myobj = [ ('Submit' , '1') , {'debug','1'} , ( 'Email' , 'demo4444@gmail.com' ),  ( 'Password' , 'demo444' ) ]

x = requests.post(url, data = myobj)
print(x.text)

