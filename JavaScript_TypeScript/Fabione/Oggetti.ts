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

const { profile: {location: {lat: lt, lng: lg, zoom = 5}}} = user;

const params2 = {
  lt,
  lg,
  zoom
}

console.log(params2)







const user2 = {
  first: 'Fabio',
  last: 'Biondi',
  //preference: 'red'
};

let {first: f, preference: pref = 'blue'} = user2;

console.log(`${f} (${pref})`)



