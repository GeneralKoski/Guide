const users = [
    {"id": 10, "name": "Silvia", "age": 2, "gender": "F", city: "Gorizia"},
    {"id": 20, "name": "Fabio", "age": 40, "gender": "M", city: "Trieste"},
    {"id": 30, "name": "Lorenzo", "age": 6, "gender": "M", city: "Pordenone"},
    {"id": 40, "name": "Lisa", "age": 40, "gender": "F", city: "Gorizia"}
  ];
  
/*
const newList = users.map(user => `${user.name} (${user.age})`)
console.log(newList);


const newList = users.filter(user => {
    return user.age > 18;
})
console.log(newList);


const ID = 3;
const index = users.find(user => user.id === ID)
const index = users.findIndex(user => user.id === ID);
console.log(index)
console.log(users)
*/

const user = { id: 50, name: 'Mario' };
let newList = [...users, user ]

const ID = 40;
newList = users.filter(u => u.id !== ID )
  
const updatedUser = { id: 20, name: 'Ciccio', age: 25 }
newList = users.map(u => u.id === updatedUser.id ? {...u, ...updatedUser} : u)
console.log(newList)
  