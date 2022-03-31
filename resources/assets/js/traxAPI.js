

    // Mock endpoints to be changed with actual REST API implementation
let traxAPI = {
    carsEndpoint(id = null) {
        return id ? '/api/car' + '/' + id : '/api/car'
    },
    tripsEndpoint(id = null) {
        return id ? '/api/trip' + '/' + id : '/api/trip';
    },
}



export { traxAPI };
