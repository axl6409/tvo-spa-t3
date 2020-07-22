import axios from 'axios'

export default {

  getDefinition (def, hash) {
    axios.get(`/api/manifest/query/${def}/${hash}`).then((response) => {
      let res = response.data['0']['json']
      let result = JSON.parse(res)
      return result['displayProperties']['name']
    })
  },

  classHashTranslation (def, id, genderHash) {
    axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
      let res = response.data['0']['json']
      let result = JSON.parse(res)
      return result['genderedClassNamesByGenderHash'][genderHash]
    })
  },

  raceHashTranslation (def, id, genderHash) {
    axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
      let res = response.data['0']['json']
      let result = JSON.parse(res)
      return result['genderedRaceNamesByGenderHash'][genderHash]
    })
  }

}
