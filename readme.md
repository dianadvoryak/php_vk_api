# Make a set of API methods for saving events and getting statistics.


The first method should take as input parameters the name of the event and the status of the user (authorized or not). The server must then add ancillary information and store the event. Use postgre as storage.

Add a note: /addevent
<img src="./img/1.png">

View all records from the database: /allstat
<img src="./img/2.png">

The second method should allow filtering.

Filter by date, event and ip: filter/?date=2023-04-04&event=online&ip=127.0.0.1
<img src="./img/3.png">

Filter by date, event: filter/?date=2023-04-02&event=focus
<img src="./img/4.png">

Filter by event: filter/?event=keydown
<img src="./img/5.png">

Filter by date: filter/?date=2023-04-01
<img src="./img/6.png">


