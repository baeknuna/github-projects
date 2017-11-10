//
//  ViewController.swift
//  final lab3
//
//  Created by 王琛阳 on 9/27/16.
//  Copyright © 2016 王琛阳. All rights reserved.
//

import UIKit

class ViewController: UIViewController {
     var currPath: draw? = nil
    var color: UIColor = UIColor.blackColor()
    var undo: Bool = false
    @IBOutlet weak var drawView: UIView!
   // var subview = UIView()
    var currentValue:CGFloat = 0
    //var change: CGFloat = 10
    @IBOutlet weak var text: UITextField!
    @IBOutlet weak var theTitle: UILabel!
   
    @IBAction func setTi(sender: AnyObject) {
        theTitle.text = text.text
    }
    //var curPath = UIBezierPath()
    override func viewDidLoad() {
        super.viewDidLoad()
        
        
    }
    @IBAction func change3(sender: AnyObject) {
          self.view.backgroundColor = UIColor.yellowColor()
    }
    @IBAction func change1(sender: AnyObject) {
        self.view.backgroundColor = UIColor.redColor()
    }
    @IBAction func change2(sender: AnyObject) {
        if(self.view.backgroundColor == UIColor.redColor()||self.view.backgroundColor == UIColor.yellowColor()){
            self.view.backgroundColor = UIColor.blueColor()
    }
 
    }
      @IBAction func redLine(sender: AnyObject) {
        //currPath!.backgroundColor = UIColor.redColor()
        color = UIColor.redColor()
        
    }
    
    @IBAction func pinkLine(sender: AnyObject) {
        color = UIColor.purpleColor()
    }
    @IBAction func blackLine(sender: AnyObject) {
        color = UIColor.blackColor()
    }
    @IBAction func blueLine(sender: AnyObject) {
        color = UIColor.blueColor()
    }
    @IBAction func yellowLine(sender: AnyObject) {
        color = UIColor.yellowColor()
    }
       @IBAction func changeRed(sender: AnyObject) {
        self.view.backgroundColor = UIColor.redColor()
    }
    @IBAction func changeBlue(sender: AnyObject) {
        if(self.view.backgroundColor == UIColor.redColor()||self.view.backgroundColor == UIColor.yellowColor()){
            self.view.backgroundColor = UIColor.blueColor()
        }
        self.view.backgroundColor = UIColor.blueColor()
        
        
    }
    
    @IBAction func changeYellow(sender: AnyObject) {
        self.view.backgroundColor = UIColor.yellowColor()
        
    }
    @IBAction func Undo(sender: AnyObject) {
        
        //       currPath?.undo = true
    }
    
    
    // Do any additional setup after loading the view, typically from a nib.
    /*let button = UIButton(frame: CGRect(x: 100, y: 100, width: 100, height: 50))
     button.backgroundColor = .greenColor()
     button.setTitle("Test Button", forState: .Normal)
     button.addTarget(self, action: #selector(clearScreen), forControlEvents: .TouchUpInside)
     
     self.view.addSubview(button)
     */
    
    /*
     let rect = CGRectMake(0, 0, 100, 100)
     
     let button1 = UIButton(type: .Custom)
     let rectangle = UIView(frame: rect)
     button1.frame = CGRectMake(0, 0, 50, 50)
     button1.backgroundColor = UIColor.redColor()
     button1.layer.cornerRadius = 0.5 * button1.bounds.size.width
     button1.addTarget(self, action: #selector(buttonPressed), forControlEvents: .TouchUpInside)
     rectangle.addSubview(button1)
     
     }
     func buttonPressed(){
     currPath?.color = UIColor.redColor()
     }
     */
    
    @IBOutlet weak var slider: UISlider!
    @IBAction func size(sender: AnyObject) {
        currentValue = CGFloat(slider.value)
        // drawView.
        
        
        
    }

    var arrayPoints = [CGPoint]()
    override func touchesBegan(touches: Set<UITouch>, withEvent event: UIEvent?) {
        
        //let myRect = CGRect(x: 0, y: 0,width: self.view.frame.width, height: self.view.frame.height*09-change)
        
        let myRect = CGRect(x: 0, y: 100,width: self.view.frame.width, height: self.view.frame.height*0.9-100)
        
        currPath = draw(frame: myRect)
        currPath!.backgroundColor = UIColor.clearColor()
        currPath!.color = color
        currPath!.size = currentValue
        currPath?.undo = undo
        
        //let touchPoint = (touches.first)!.locationInView(self.view) as CGPoint
        let touchSet = touches
        
        for touch in touchSet{
            //let location = touch.locationInView(self.view)
            var touchPoint = touch.locationInView(self.view) as CGPoint
            // touchPoint.y = touchPoint.y - change
            //arrayPoints.append(touchPoint)
            //currPath?.arrayOfPoints = arrayPoints
            touchPoint.y = touchPoint.y - 100
            currPath?.arrayOfPoints.append(touchPoint)
            //arrayPoints.append(touchPoint)
        }
        
        
        self.view.addSubview(currPath!)
        
        
        //self.setNeedsDisplay()
        
        //let path = UIBezierPath()
    }
    
    override func touchesMoved(touches: Set<UITouch>, withEvent event: UIEvent?) {
        
        //let touchPoint = (touches.first)!.locationInView(self.view) as CGPoint
        let touchSet = touches
        //let myRect = CGRect(x:0, y: 0, width:self.view.frame.width, height: self.view.frame.height)
        
        for touch in touchSet{
            //let location = touch.locationInView(self.view)
            //let touchPoint = touch.locationInView(drawView)
            var touchPoint = touch.locationInView(self.view) as CGPoint
              touchPoint.y = touchPoint.y - 100
            // touchPoint.y = touchPoint.y - change
            //arrayPoints.append(touchPoint)
            //currPath?.arrayOfPoints = arrayPoints
            currPath?.arrayOfPoints.append(touchPoint)
            //arrayPoints.append(touchPoint)
        }
        
        
       // self.setNeedsDisplay()
        
        
        
        
        //let view = UIView(frame: CGRectMake(0,0,1000,1000))
        //view.backgroundColor = UIColor.blueColor()
        // create CAShapeLayer
        // let shapeLayer = CAShapeLayer()
        // shapeLayer.path = createQuadPath(arrayPoints).CGPath
        // shapeLayer.fillColor = UIColor.whiteColor().CGColor
        // shapeLayer.fillRule = kCAFillRuleEvenOdd
        // view.layer.mask = shapeLayer
        
        //If you want to stroke it with a red color
        // UIColor.redColor().set()
        //createQuadPath(arrayPoints).stroke()
        //If you want to fill it as well
        //createQuadPath(arrayPoints).fill()
        
        
        //self.setNeedsDisplay()
        
        //let path = UIBezierPath()
    }
    override func touchesEnded(touches: Set<UITouch>, withEvent event: UIEvent?) {
        let touchSet = touches
        //let myRect = CGRect(x:0, y: 0, width:self.view.frame.width, height: self.view.frame.height)
        
        for touch in touchSet{
            //let location = touch.locationInView(self.view)
            var touchPoint = touch.locationInView(self.view) as CGPoint
              touchPoint.y = touchPoint.y - 100
            //touchPoint.y = touchPoint.y - change
            //arrayPoints.append(touchPoint)
            //currPath?.arrayOfPoints = arrayPoints
            currPath?.arrayOfPoints.append(touchPoint)
            //arrayPoints.append(touchPoint)
        }
        if(undo == true){
           // currPath?.createQuadPath((currPath?.arrayOfPoints)!).removeAllPoints()
            //currPath?.removeFromSuperview()
        
        }
       // self.setNeedsDisplay()
        
        
    }
    @IBAction func undo(sender: AnyObject) {
        undo = true
        currPath?.removeFromSuperview()
        
    }
    

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    //let circlePath = UIBezierPath(arcCenter: CGPoint(x: 100,y: 100), radius: CGFloat(20), startAngle: CGFloat(0), endAngle:CGFloat(M_PI * 2), clockwise: true)
    // func drawRect(rect: CGRect){
    //  UIColor.greenColor().setFill()
    //let circleRadius: CGFloat = self.bounds.height/2
    // let path = UIBezierPath()
    // }
    
    @IBOutlet weak var clear: UIButton!
    //clear.addTarget()
    //then make a action method :
    
    
    @IBAction func clear(sender: AnyObject) {
        for v in view.subviews{
            if (v is draw){
                v.removeFromSuperview()
            }
            
        }
        
    }
    /*
     func clearScreen(sender: UIButton!) {
     for v in view.subviews{
     if (v is draw){
     v.removeFromSuperview()
     }
     
     }
     
     
     }*/
    
}


