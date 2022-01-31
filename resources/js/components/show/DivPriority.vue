<template>
  <div id="priorityId" :class="changePriorityColor()"  style="
                                     color: white;
                                     vertical-align:middle;
                                     border-style: solid;
                                     border-radius:10px;
                                     border-width: 1px;
                                     border-color: white;
                                     padding:5px;
                                     text-align:center;
                                     ">
    {{ priority }}
  </div>
</template>

<script>
export default {
  props: ["priority"],
  mounted() {
    console.log(this.priority);
  },
  methods: {
    changePriorityColor() {
      switch (this.priority) {
        case "baixa":
          return "low2";
          break;
        case "média":
          return "medium2";
          break;
        case "alta":
          return "high2";
          break;
        case "emergência":
          return "emergency2";
          break;
      }
    },
  },
};
</script>

<style lang="css">
.emergency2{
    color: white;
    background-color: #392F6D;
}

.high2{
    background-color: #6357A1;
}

.low2{
    color: white;
    background-color: #B9A4D0;
}

.medium2{
    color: white;
    background-color: #9A8ABF;
}
</style>