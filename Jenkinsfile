pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/curso:devops"
		dockerImage1 = ""
		dockerImageName2 = "carlarodriguezag/curso:devops"
		dockerImage2 = ""
	}

 agent any

	stages {
	 stage('Revisar Código'){
	  steps{
	   dir('aplicacion'){
	    script {
	     dockerImage1 = docker.build dockerImageName1
	    }
 	   }

	   dir('Phpmyadmin'){
	    script {
	     dockerImage2 = docker.build dockerImageName2
	    }
 	   }		
	  }
	 }


	 stage('Construir Imagen') {
	  steps{
	   dir('aplicacion'){
	    script {
	     dockerImage1 = docker.build dockerImageName1
	    }
	   }

	    dir('Phpmyadmin'){
	    script {
	     dockerImage2 = docker.build dockerImageName2
	    }
	   }
	  }
	 } 

	 stage('Subir Imagen App') {
	  environment {
	   registryCredential = 'dockerhub_curso'
	   }
	  steps {
		dir('aplicacion') {
		 script {
			docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
			dockerImage1.push("devops")
			 }
			}

		 dir('Phpmyadmin') {
		 script {
			docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
			dockerImage2.push("devops")
			 }
			}
		  }
	    }
      }


	}
}
}