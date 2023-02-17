pipeline {
	environment{
		dockerImageName1 = "carlarodriguezag/curso:devops"
		dockerImage1 = ""
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
	  }
	 }


	 stage('Construir Imagen') {
	  steps{
	   dir('aplicacion'){
	    script {
	     dockerImage1 = docker.build dockerImageFile1
	    }
	   }
	  }
	 }
	}	
}