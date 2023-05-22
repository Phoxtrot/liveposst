<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


</head>
<body>
    <script>
        // function getCookie(name){
        //     const value = `; ${document.cookie}`
        //     const part = value.split(`; ${name}=`)
        //     if (part.length === 2) {
        //         return  part.pop().split(';').shift()
        //     }

        // }
        function login(){
            axios.post('/login', {
                email: "jane@doe.com",
                password: "password"
            }).then((res)=>{
                console.log("Response is");
            })
        }
        function logout(){
            axios.post('/logout')
        }
        // Get users
        function getUsers(){
            axios.get('/api/v1/users')
        }
        axios.get('/sanctum/csrf-cookie').then((response)=>{
                console.log("Response is", response);
            })
            .then(login())
            .then(getUsers());

            // function test(){
        //     axios.post('/test',{
        //         email: "john@doey.com",
        //         password: "password"
        //     },
        //     {
        //         headers: {
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        //         }
        //     }).then((res)=>{
        //         console.log("response is",res);
        //     })
        // }

    </script>
</body>
</html>
