<template>
  <div
    id="priorityId"
    :class="changePriorityColor()"
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
        case "prospecção":
          return "prospecting2";
          break;
        case "apresentação":
          return "presentation2";
          break;
        case "proposta":
          return "proposal2";
          break;
        case "contrato":
          return "contract";
          break;
        case "cobrança":
          return "bill2";
          break;
        case "produção":
          return "production2";
          break;
        case "concluída":
          return "conclude2";
          break;
      }
    },
  },
};
</script>

<style lang="css">
.emergency2 {
  background-color: #392f6d;
}

.high2 {
  background-color: #6357a1;
}

.low2 {
  background-color: #b9a4d0;
}

.medium2 {
  background-color: #9a8abf;
}

.prospecting2{
    background-color: #8B2485;
}

.presentation2{
    background-color: #957799;
}

.proposal2{
    background-color: #EDB4F4;
}
.published2{
    background-color: #49d194;
}

.dealing2{
    background-color: #EDD500;
}

.bill2{
    background-color: #F7AFB4;
}

.contract1{
    background-color: #92C4D4;
}

.production2{
    background-color: #09FBBE;
}

.conclude2{
    background-color: #20EB48;
}
</style>