const list = [10, 20, 30, 40 ,50];

const [a, b, ...rest] = list;
const result = list.concat(60);
console.log(result);

const clonelist = [...list, ...result, 70, 80];
console.log(clonelist);

const obj = {
    id: 123,
    name: 'Fabio'
}

const preferences = {color: 'red'};
const cloneobj = {...obj, ...preferences, pet: 'dog'};
cloneobj.id = 456;

console.log(cloneobj)