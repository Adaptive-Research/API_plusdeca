import requests

#url = 'http://API.test:8011/API/Modifier-Event'
url = 'http://plusdeca.api2/API/Modifier-Event'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), {'idEvent','1'}, ( 'Event_Type' , '1' ) , ( 'Event_Title' , 'test2' ),('Event_AllDay','1') , ('Event_Start','2022-10-28') ,('Event_End','')  ,('Event_Location','Nemours') ,('Event_Data','test3') ]

x = requests.post(url, data = myobj)
print(x.text)

