import { ref } from 'vue';

export function useModal() {
  const isModalOpen = ref(false);
  const currentComponent = ref(null);
  const modalProps = ref({});
  const modalOptions = ref({});

  const openModal = (component, props = {}, options = {}) => {
    currentComponent.value = component;
    modalProps.value = props;
    modalOptions.value = options;
    isModalOpen.value = true;
  };

  const closeModal = () => {
    isModalOpen.value = false;
    currentComponent.value = null;
    modalProps.value = {};
    modalOptions.value = {};
  };

  return {
    isModalOpen,
    currentComponent,
    modalProps,
    modalOptions,
    openModal,
    closeModal
  };
}
