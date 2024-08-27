<template>
    <div>
        <PersonalInfo :data="profile"></PersonalInfo>
        <ProfileDetails :data="profile"></ProfileDetails>
        <ProfileChangePassword></ProfileChangePassword>
    </div>
</template>
<script>
import PersonalInfo from './partial/PersonalInformation.vue';
import ProfileDetails from './partial/ProfileDetails.vue';
import ProfileChangePassword from './partial/ProfileChangePassword.vue';
export default {
    name: "Index",
    components: {
        PersonalInfo,
        ProfileDetails,
        ProfileChangePassword
    },
    data() {
        return {
            profile:[]
        }
    },
    methods: {
       async getProfile() {
           await axios.get('/profile/show').then(response => {
                this.profile = response.data;
            })
        }
    },
    mounted() {
        this.getProfile();
    }
}
</script>
<style scoped>

</style>
