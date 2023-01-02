import requests

url = 'http://API.test:8011/API/Publier-Article'
#url = 'http://plusdeca.api/API/Publier-Article'



myobj = [ ('Submit' , '1'), ( 'debug' , '1' ), ('token', '17;0c5ea12414fa5fb45cdd6cfca4e6f14bdd6fc0a4e96de3dbd68779c9824b'), ( 'idAncestor' , '1' ) , ( 'NumVersion' , '11' ) ]
x = requests.post(url, data = myobj)
print(x.text)

