<template>
    <div v-if="itemMetadatum">
      <b-field grouped>
        <b-select
          expanded 
          v-model="selectedState"
          placeholder="Selecione um estado"
          @input="onInput"
        >
          <option 
            v-for="(estado, id) in estados"
            :value="id"
            :key="id">
            {{ estado.nome }}
          </option>
        </b-select>
        <b-select 
          expanded
          :disabled="!selectedState"
          v-model="selectedCity"
          placeholder="Selecione uma cidade"
          @input="onInput"
        >
          <option 
            v-for="(cidade, id) in getCidades"
            :value="id"
            :key="id">
            {{ cidade }}
          </option>
        </b-select>
      </b-field>
  </div>
</template>

<script>
import estados from './estados.json';
import cidades from './cidades.json';

export default {
  name: "CidadesBrMetadataType",
  data() {
    return {
      estados: estados,
      cidades: cidades,
      selectedState: null,
      selectedCity: null,
    }
  },
  props: {
    itemMetadatum: Object,
    value: [String],
    disabled: false,
  },
  computed: {
    getCidades: function () {
      const currentState = this.selectedState;
      const cidades = this.cidades;
      if ( currentState ) {
        return Object.keys( this.cidades )
          .filter( key => key.startsWith( currentState ) )
          .reduce( ( obj, key ) => {
            obj[key] = this.cidades[key];
            return obj;
          }, {} );
      }
    },
  },
  methods: {
    onInput: function () {
      this.$emit( "input", this.getFinalValue() );
    },
    onBlur: function () {
      this.$emit("blur");
    },
    getFinalValue: function () {
      if ( this.selectedCity ) {
        return this.selectedCity;
      } else if ( this.selectedState ) {
        return this.selectedState;
      }
      return null;
    }
  },
  mounted() {
    console.log(this.value);
    console.log(this.value.length);
    console.log(this.value.substring(0,2));
    if ( this.value ) {
      if ( this.value.length > 2 ) {
        this.selectedCity = this.value;
        this.selectedState = this.value.substring(0,2);
      } else if ( this.value.length === 2 ) {
        this.selectedState = this.value;
      }
    }
  }
};
</script>

<style>
/* How about some custom style here? */
</style>
