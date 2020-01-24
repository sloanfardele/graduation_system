# Students graduation system

This is a REST API to manage students and their graduations

## Usage

### Student creation

To create a student, call in **POST** 

```http
http://yourdomain/students
```

with these data

```json
{
  "firstName": "FIRSTNAME",
  "lastName": "LASTNAME",
  "birthdate": "Y-m-d"
}
```

Replace **FIRSTNAME**, **LASTNAME** and **Y-m-d** with the wanted data



#### Response

```json
{"message":"New student save with id : X"}
```

**X** is the id of the saved user



### Student retrievment

To get a student, call in **GET**

```http
http://yourdomain/students/{id}
```

Replace **{id}** by the wanted student identifier



#### Response

```json
{
  "id": "ID",
  "firstName": "FIRSTNAME",
  "lastName": "LASTNAME",
  "birthdate": "Y-m-d"
}
```

**ID**, **FIRSTNAME**, **LASTNAME** and **Y-m-d** are the data of the required user 



### Student edition

To edit a student, call in **PUT**

```http
http://yourdomain/students
```

with these data

```json
{
  "id": "ID",
  "firstName": "NEW_FIRSTNAME",
  "lastName": "NEW_LASTNAME",
  "birthdate": "NEW_Y-m-d"
}
```

**ID** is the student identifier of the student to edit.

Replace **NEW_FIRSTNAME**, **NEW_LASTNAME**, **NEW_Y-m-d** with the new data to add to the student.

Only add in the data body the data to edit.

I.E to edit only the first name :

```json
{
  "id": "ID",
  "firstName": "NEW_FIRSTNAME"
}
```



#### Response

```json
{"message":"User X updated"}
```

**X** is the id of the updated user



### Mark creation

To create a mark and assign it to a student, call in **POST**

```http
http://yourdomain/marks
```

with these data 

```json
{
	"value": VALUE,
  "subject": "SUBJECT",
  "studentId": STUDENT_ID
}
```

Replace **VALUE**, **SUBJECT** AND **STUDENT_ID** with the wanted data. 

Value might be between 0 and 20.



#### Response

```json
{"message":"Mark added to student with id : X"}
```

**X** is the id of the added mark



### Student average retrievment

To get a student average, call in **GET**

```http
http://yourdomain/marks/student/{id}
```

Replace **{id}** with the student identifier.



#### Response

```json
{"average":X}
```

**X** is the average of the student



### Classroom average retrievment

To get the classroom average, call in **GET**

```http
http://yourdomain/marks/students
```



#### Response

```json
{"average":X}
```

**X** is the classroom average



### Success

In case of success, the API will return a response with HTTP code **200** and data according to each request as detailled above.



### Errors

In case of error, the API will return a response with HTTP code **500** and data like :

```json
{
	"message": "ERROR_MESSAGE"
}
```

