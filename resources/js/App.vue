<template>
  <div>
      <div class="container">
        <Nav />
        <RouterView />
      </div>
  </div>
</template>
<script>
import Nav from "./pages/Nav";
export default {
  components: { Nav }
}
</script>
