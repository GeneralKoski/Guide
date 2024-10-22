const user = {
  id: 123,
  name: 'Fabio',
  surname: 'Biondi',
  profile: {
    color: 'black',
    location: {
      lat: 15, lng: 12
    },
  }
};

const params = {id: user.id, color: user.profile.color}
console.log(params);

const { profile: {location: {lat: lt, lng: lg}}} = user;

const params2 = {
  lt,
  lg
}

console.log(params2);

let user2 = {
  first: 'Fabio',
  last: 'Biondi',
};

let {first: f, last: l, preference: pref = 'blue'} = user2;

console.log(`${f} ${l} (${pref})`)



