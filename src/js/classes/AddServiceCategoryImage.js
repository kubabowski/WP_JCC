class ServiceCategoryImagePicker {
    constructor(buttonSelector) {
      this.mediaUploader = null;
      this.buttonSelector = buttonSelector;
      this.init();
    }
  
    init() {
      document.querySelectorAll(this.buttonSelector).forEach(button => {
        button.addEventListener('click', event => this.openMediaUploader(event, button));
      });
    }
  
    openMediaUploader(event, button) {
      event.preventDefault();
  
      const targetInputSelector = button.getAttribute('data-target');
      const targetInput = document.querySelector(targetInputSelector);
      const previewContainer = targetInput
        .closest('.form-field')
        .querySelector('#service-category-image-preview img');
  
      if (this.mediaUploader) {
        this.mediaUploader.open();
        return;
      }
  
      this.mediaUploader = wp.media({
        title: 'Select Service Category Image',
        button: { text: 'Use this image' },
        multiple: false,
      });
  
      this.mediaUploader.on('select', () => {
        const attachment = this.mediaUploader.state().get('selection').first().toJSON();
        targetInput.value = attachment.url;
        previewContainer.src = attachment.url;
      });
  
      this.mediaUploader.open();
    }
  }
  
  // Initialize the image picker once the DOM is fully loaded
  document.addEventListener('DOMContentLoaded', () => {
    new ServiceCategoryImagePicker('.upload-image-button');
  });
  