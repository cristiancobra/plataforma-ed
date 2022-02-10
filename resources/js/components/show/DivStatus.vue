<template>
  <div
    id="statusId"
    :class="changeStatusColor()"
    style="
      color: white;
      vertical-align: middle;
      border-style: solid;
      border-radius: 10px;
      border-width: 1px;
      border-color: white;
      padding: 5px;
      text-align: center;
    "
  >
    {{ status }}
  </div>
</template>

<script>
export default {
  props: ["status"],
  mounted() {
    console.log(this.status);
  },
  methods: {
    changeStatusColor() {
      switch (this.status) {
        case "fazendo":
        case "negociando":
          return "doing2";
          break;
        case "fazer":
          case "revisão":
        case "orçamento":
          return "to-do2";
          break;
        case "feito":
        case "ativada":
        case "aprovada":
        case "disponível":
          return "done2";
          break;
        case "rascunho":
          return "lost2";
          break;
      }
    },
  },
};
</script>

<style lang="css">
.doing2 {
  color: white;
  background-color: #92c4d4;
}
.to-do2 {
  color: white;
  background-color: #ecd23d;
}
.done2 {
  color: white;
  background-color: #a5d9cc;
}
.lost2 {
  color: white;
  background-color: #EF5362;
}
</style>