<template>
    <div id="wrapper">
        <router-view id="left-sidebar" name="left-sidebar"/>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <header-default/>

                <div class="container-fluid">
                    <router-view class="d-flex flex-column" name="main"/>
                </div>
            </div>

            <footer-default/>
        </div>
        <router-view id="right-sidebar" name="right-sidebar"/>
    </div>
</template>

<script setup>
import HeaderDefault from '@/Components/Header/Default';
import FooterDefault from '@/Components/Footer/Default';
</script>
