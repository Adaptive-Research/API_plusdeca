import requests

url = 'http://API.test:8011/API/Creer-Event'
url = 'http://plusdeca.api2/API/Creer-Event'



myobj = [ ('Submit' , '1'), ('debug','1'),  ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'Event_Type' , '1' ) , ( 'Event_Title' , 'test1' ), ( 'Event_AllDay' , '0' ),('Event_Start','2022/11/01') ,('Event_End','2022/11/01'),('Event_Location','Paris'), ('Event_Data','test2') ]

x = requests.post(url, data = myobj)
print(x.text)

