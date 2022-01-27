<template>
    <div id="statusId" style="background-color:white">
       {{status}}
    </div>
</template>

<script>
    export default {

props: ['status'],
        methods() {
            changeStatus() {
                switch (status) {
                    case 'fazendo':
                        console.log('fazendo');
                    break;
                    case 'fazer':
                        console.log('fazer!!');
                        break;
                }

    document.getElementById('statusId').style = "background-color:red";

        };
    }
    }
</script>
