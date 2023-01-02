import requests

url = 'http://78.249.128.56:8011/API/Show-BusinessCards'



myobj = [ ('Submit' , '1'), ('debug' , '1'), ('token', '20;3996db57d3df0506be6e1f8a9fe43252ebc7722a73b7773f2b2c69b36f46') ]

x = requests.post(url, data = myobj)
print(x.text)

