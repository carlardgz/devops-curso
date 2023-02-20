pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/app:devops"
		dockerImage1 = ""
		dockerImageName2 = "carlarodriguezag/phpmyadmin:devops"
		dockerImage2 = ""
		dockerImageName3 = "carlarodriguezag/mysql:devops"
		dockerImage3 = ""
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

	   dir('Mysql'){
	    script {
	     dockerImage3 = docker.build dockerImageName3
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

	    dir('Mysql'){
	    script {
	     dockerImage3 = docker.build dockerImageName3
	    }
	   }
	  }
	 } 

	 stage('Subir Imagen') {
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

		 
		 dir('Mysql') {
		 script {
			docker.withRegistry('https://registry.hub.docker.com', registryCredential) {
			dockerImage3.push("devops")
			 }
			}
		  }
	    }
      }


	}
}
}