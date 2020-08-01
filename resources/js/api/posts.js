import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:3000'
})

function getPostsApi (cb) {
  api.get('/api/posts/all')
    .then((response) => {
      cb(response.data)
    })
    .catch((error) => {
      console.log(error)
    })
}

function saveDataApi (data, cb) {
  api.post('/api/posts/store', data)
    .then(function (response) {
      cb(response)
    })
    .catch((error) => {
      console.log(error)
    })
}

function updateData (idPost, data, cb) {
  api.put('/api/posts/update/' + idPost, data)
    .then((response) => {
      cb({ status: 201 })
    })
    .catch((error) => {
      console.log(error)
    })
}

function deleteData (idPost, cb) {
  api.delete('/api/posts/delete/' + idPost)
    .then((response) => {
      cb(response)
    })
    .catch((error) => {
      console.log(error)
    })
}

export default {
  getPosts: (cb) => getPostsApi(cb),
  savePost: (data, cb) => saveDataApi(data, cb),
  updatePost: (idPost, data, cb) => updateData(idPost, data, cb),
  deletePost: (idPost, cb) => deleteData(idPost, cb)
}
